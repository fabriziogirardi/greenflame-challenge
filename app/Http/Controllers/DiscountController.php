<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditDiscountRequest;
use App\Http\Requests\StoreDiscountRequest;
use App\Models\AccessType;
use App\Models\Brand;
use App\Models\Discount;
use App\Models\DiscountRange;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // Possible columns to be sorted
        $sort_columns = [
            'brand_name',
            'region_code',
            'name',
            'active',
            'access_type_name',
            'priority',
        ];

        // Populate search array with search parameters
        $search = [];
        if ($request->get('brand_id')) {
            $search['brand_id'] = $request->get('brand_id');
        }
        if ($request->get('access_type_code')) {
            $search['access_type_code'] = $request->get('access_type_code');
        }
        if ($request->get('name')) {
            $search['name'] = $request->get('name');
        }
        if ($request->get('code')) {
            $search['code'] = $request->get('code');
        }

        // Define sorting values or use defaults
        $sort = in_array($request->get('order_by'), $sort_columns) ? $request->get('order_by') : 'id';
        $direction = in_array($request->get('direction'), ['ASC', 'DESC']) ? $request->get('direction') : 'ASC';

        // Start query builder
        $discounts_base = Discount::query();

        // Make necessary joins, filter ranges, and select fields
        $discounts = $discounts_base->join('brands', 'discounts.brand_id', '=', 'brands.id')
            ->join('access_types', 'discounts.access_type_code', '=', 'access_types.code')
            ->join('regions', 'discounts.region_id', '=', 'regions.id')
            ->whereHas('discount_range', function($q) use ($search) {
                if (!empty($search['code'])) {
                    return $q->where('code', 'like', '%' . $search['code'] . '%');
                }
            })
            ->select([
                'discounts.*',
                'brands.name as brand_name',
                'access_types.name as access_type_name',
                'regions.code as region_code'
            ])
            ->with('discount_range');

        // Perform Where clauses based on search parameters
        foreach ($search as $k => $v) {
            if ($k == 'code')
                continue;
            if ($k == 'name') {
                $discounts->where('discounts.name', 'like', '%' . $v . '%');
            } else {
                $discounts->where($k, $v);
            }
        }

        // Finish query builder, sort, and paginate
        $discounts = $discounts->orderBy($sort, $direction)
            ->orderBy('id', 'ASC')
            ->paginate(10)
            ->withQueryString();

        // Additional models to populate view
        $brands = Brand::query()->where('active', true)->orderBy('display_order', 'asc')->get();
        $access_types = AccessType::orderBy('display_order', 'asc')->get();

        // Return view with data
        return response()->view('app.discounts.index', compact('access_types', 'brands', 'discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get records from database to populate the view
        $regions = Region::orderBy('display_order', 'asc')->get();
        $brands = Brand::query()->where('active', true)->orderBy('display_order', 'asc')->get();
        $access_types = AccessType::orderBy('display_order', 'asc')->get();

        // Return the view with the records
        return response()->view('app.discounts.create', compact('regions', 'brands', 'access_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscountRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreDiscountRequest $request)
    {
        // Discount and first range creations
        $discount = Discount::create($request->validated());
        DiscountRange::create(array_merge($request->period_1, ['discount_id' => $discount->id]));


        // Subsequent ranges if present
        if ($request->has('period_2')) {
            DiscountRange::create(array_merge($request->period_2, ['discount_id' => $discount->id]));
        }

        if ($request->has('period_3')) {
            DiscountRange::create(array_merge($request->period_3, ['discount_id' => $discount->id]));
        }

        // Return to index with message
        return redirect()->route('discount.index')->with('message', trans('main.store_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Load data to populate form
        $discount = Discount::with(['brand', 'region', 'access_type', 'discount_range'])->find($id);
        $regions = Region::orderBy('display_order', 'asc')->get();
        $brands = Brand::query()->where('active', true)->orderBy('display_order', 'asc')->get();
        $access_types = AccessType::orderBy('display_order', 'asc')->get();

        // Return response with data
        return response()->view('app.discounts.edit', compact('discount', 'regions', 'brands', 'access_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditDiscountRequest $request
     * @param int                 $id
     *
     * @return RedirectResponse
     */
    public function update(EditDiscountRequest $request, int $id)
    {
        // Find the record to edit
        $discount = Discount::find($id);

        // Delete related ranges
        $discount->discount_range()->delete();

        // Update new data and save
        $discount->update($request->validated());
        $discount->save();


        // Create new ranges according to new data
        DiscountRange::create(array_merge($request->period_1, ['discount_id' => $id]));

        if ($request->has('period_2')) {
            DiscountRange::create(array_merge($request->period_2, ['discount_id' => $discount->id]));
        }

        if ($request->has('period_3')) {
            DiscountRange::create(array_merge($request->period_3, ['discount_id' => $discount->id]));
        }

        // Return to index with message
        return redirect()->route('discount.index')->with('message', trans('main.edit_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        // Delete record and associated data
        $discount = Discount::find($id);
        $discount->discount_range()->delete();
        $discount->delete();

        // Return to index with message
        return response()->redirectToRoute('discount.index')->with('message', trans('main.delete_success'));
    }
}
