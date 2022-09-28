<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-gray-800 leading-tight">
            <div class="p-6 bg-white border-gray-200 flex">
                <div class="w-2/3">
                    <div class="text-xl text-gray-800 font-bold pb-2">
                        {{ __('app/discounts/list.discounts_heading') }}
                    </div>
                    <div class="text-sm text-blue-500">
                        {{ __('app/discounts/list.discounts_description') }}
                    </div>
                </div>
                <div class="w-1/3">
                    <div class="flex gap-2 w-fit ml-auto">
                        <a href="{{ route('discount.create') }}"><div class="font-bold p-2 rounded bg-sky-800 text-neutral-200 w-fit self-center">
                            {{ __('app/discounts/list.new_discount') }}</div></a>
                        <div class="font-bold p-2 rounded bg-neutral-200 text-neutral-400 w-fit self-center cursor-not-allowed">
                            {{ __('app/discounts/list.export') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @if(session()->has('message'))
        <div class="max-w-6xl mx-auto py-2 px-6 mt-2 border rounded bg-cyan-600 text-neutral-100">{{ session()->get('message') }}</div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mt-4 mb-8">
                    <form method="GET">
                        <div class="px-6 py-2 flex items-center gap-2">
                            <div class="flex flex-col w-1/6">
                                <div class="font-bold ml-2">
                                    {{ __('app/discounts/list.brand_label') }}
                                </div>
                                <div>
                                    <select class="rounded border-gray-300 w-full" name="brand_id">
                                        <option disabled selected>{{ __('app/discounts/list.option_select') }}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ (Request::get('brand_id') == $brand->id) ? 'selected' : '' }} >{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-col w-1/6">
                                <div class="font-bold ml-2">
                                    {{ __('app/discounts/list.access_type_label') }}
                                </div>
                                <div>
                                    <select class="rounded border-gray-300 w-full" name="access_type_code">
                                        <option disabled selected>{{ __('app/discounts/list.option_select') }}</option>
                                        @foreach($access_types as $access_type)
                                            <option value="{{ $access_type->code }}" {{ (Request::get('access_type_code') == $access_type->code) ? 'selected' : '' }} >{{ $access_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-col w-1/6">
                                <div class="font-bold ml-2">
                                    {{ __('app/discounts/list.rule_name_label') }}
                                </div>
                                <div>
                                    <input name="name" id="name" type="text"
                                           class="w-full border border-gray-300 rounded rounded-md text-neutral-700"
                                           placeholder="{{ __('app/discounts/list.placeholder_name') }}"
                                           value="{{ Request::get('name') }}"/>
                                </div>
                            </div>
                            <div class="flex flex-col w-1/6">
                                <div class="font-bold ml-2">
                                    {{ __('app/discounts/list.awd_bcd_label') }}
                                </div>
                                <div>
                                    <input name="code" id="name" type="text"
                                           class="w-full border border-gray-300 rounded rounded-md text-neutral-700"
                                           placeholder="{{ __('app/discounts/list.placeholder_code') }}"
                                           value="{{ Request::get('code') }}"/>
                                </div>
                            </div>
                            <div class="flex flex-col w-2/6">
                                <div class="flex justify-end align-middle gap-2">
                                    <input class="p-2 px-4 bg-sky-900 text-neutral-100 rounded" type="submit"
                                           value="{{ __('app/discounts/list.search_filter_button') }}"/>
                                    <a href="{{ route('discount.index') }}">
                                        <div
                                            class="cursor-pointer p-2 px-4 bg-neutral-200 text-neutral-700 border border-neutral-400 rounded">{{ __('app/discounts/list.reset_filter_button') }}</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-10 text-sm">
                <div class="my-8 mx-4">
                    <div class="font-bold flex gap-2 text-center mb-8">
                        <div class="w-32">
                            <a href="{{ route('discount.index') }}?{{ http_build_query(Request::except(['order_by', 'direction'])) . (Request::has('direction') && Request::get('direction') == 'ASC') ? '&order_by=brand_name&direction=DESC' : '&order_by=brand_name&direction=ASC' }}">
                                {{ __('app/discounts/list.brand_label') }} {{ (Request::has('direction') && Request::get('direction') == 'ASC') ? '(DESC)' : '(ASC)' }}
                            </a>
                        </div>
                        <div class="w-12">
                            <a href="{{ route('discount.index') }}?{{ http_build_query(Request::except(['order_by', 'direction'])) . (Request::has('direction') && Request::get('direction') == 'ASC') ? '&order_by=region_code&direction=DESC' : '&order_by=region_code&direction=ASC' }}">
                                {{ __('app/discounts/list.region_label') }} {{ (Request::has('direction') && Request::get('direction') == 'ASC') ? '(DESC)' : '(ASC)' }}
                            </a>
                        </div>
                        <div class="w-28">
                            <a href="{{ route('discount.index') }}?{{ http_build_query(Request::except(['order_by', 'direction'])) . (Request::has('direction') && Request::get('direction') == 'ASC') ? '&order_by=name&direction=DESC' : '&order_by=name&direction=ASC' }}">
                                {{ __('app/discounts/list.rule_name_label') }} {{ (Request::has('direction') && Request::get('direction') == 'ASC') ? '(DESC)' : '(ASC)' }}
                            </a>
                        </div>
                        <div class="w-24">
                            <a href="{{ route('discount.index') }}?{{ http_build_query(Request::except(['order_by', 'direction'])) . (Request::has('direction') && Request::get('direction') == 'ASC') ? '&order_by=access_type_name&direction=DESC' : '&order_by=access_type_name&direction=ASC' }}">
                                {{ __('app/discounts/list.access_type_label') }} {{ (Request::has('direction') && Request::get('direction') == 'ASC') ? '(DESC)' : '(ASC)' }}
                            </a>
                        </div>
                        <div class="w-24">
                            <a href="{{ route('discount.index') }}?{{ http_build_query(Request::except(['order_by', 'direction'])) . (Request::has('direction') && Request::get('direction') == 'ASC') ? '&order_by=active&direction=DESC' : '&order_by=active&direction=ASC' }}">
                                {{ __('app/discounts/list.active_column') }} {{ (Request::has('direction') && Request::get('direction') == 'ASC') ? '(DESC)' : '(ASC)' }}
                            </a>
                        </div>
                        <div class="w-16">
                            {{ __('app/discounts/list.period_column') }}
                        </div>
                        <div class="w-20">
                            {{ __('app/discounts/list.awc_bcd_column') }}
                        </div>
                        <div class="w-28">
                            {{ __('app/discounts/list.gsa_discount_column') }}
                        </div>
                        <div class="w-32">
                            {{ __('app/discounts/list.period_column') }}
                        </div>
                        <div class="w-24">
                            <a href="{{ route('discount.index') }}?{{ http_build_query(Request::except(['order_by', 'direction'])) . (Request::has('direction') && Request::get('direction') == 'ASC') ? '&order_by=priority&direction=DESC' : '&order_by=priority&direction=ASC' }}">
                                {{ __('app/discounts/list.priority_column') }} {{ (Request::has('direction') && Request::get('direction') == 'ASC') ? '(DESC)' : '(ASC)' }}
                            </a>
                        </div>
                        <div class="w-12">
                        </div>
                        <div class="w-12">
                        </div>
                    </div>
                    @foreach($discounts as $discount)
                        <div class="flex gap-2 text-center mb-4">
                            <div class="w-32">
                                {{ $discount->brand_name }}
                            </div>
                            <div class="w-12">
                                {{ $discount->region_code }}
                            </div>
                            <div class="w-28">
                                {{ $discount->name }}
                            </div>
                            <div class="w-24">
                                {{ $discount->access_type_name }}
                            </div>
                            <div class="w-24">
                                {{ $discount->active ? __('app/discounts/list.active_description') : __('app/discounts/list.inactive_description') }}
                            </div>
                            <div class="w-16">
                                @foreach($discount->discount_range as $range)
                                    {{ $range->from_days }} - {{ $range->to_days }}<br/>
                                @endforeach
                            </div>
                            <div class="w-20">
                                @foreach($discount->discount_range as $range)
                                    {{ $range->code ?? '---' }}<br/>
                                @endforeach
                            </div>
                            <div class="w-28">
                                @foreach($discount->discount_range as $range)
                                    {{ $range->discount ? $range->discount . '%' : '---' }}<br/>
                                @endforeach
                            </div>
                            <div class="w-32">
                                {{ $discount->period }}
                            </div>
                            <div class="w-24">
                                {{ $discount->priority }}
                            </div>
                            <div class="w-12 mt-2 mr-2">
                                <a class="cursor-pointer px-4 py-2 bg-blue-600 text-neutral-100 rounded"
                                   href="{{ route('discount.edit', ['discount' => $discount->id]) }}">{{ __('app/discounts/list.edit_column') }}</a>
                            </div>
                            <div class="w-12">
                                <form action="{{ route('discount.destroy', ['discount' => $discount->id]) }}"
                                      method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input class="cursor-pointer px-4 py-2 bg-red-600 text-neutral-100 rounded"
                                           type="submit" value="{{ __('app/discounts/list.delete_column') }}"/>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="ml-auto px-10 py-4 max-w-lg">
                    {{ $discounts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
