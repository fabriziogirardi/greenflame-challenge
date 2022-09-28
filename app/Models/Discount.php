<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder
 */
class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'priority',
        'active',
        'region_id',
        'brand_id',
        'access_type_code',
    ];

    /**
     * Region relationship
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Brand relationship
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Access type relationship
     * @return BelongsTo
     */
    public function access_type(): BelongsTo
    {
        return $this->belongsTo(AccessType::class);
    }

    /**
     * Discount range relationship
     * @return HasMany
     */
    public function discount_range(): HasMany
    {
        return $this->hasMany(DiscountRange::class);
    }

    /**
     * Change format from front-end to back-end compatible
     *
     * @param $value
     *
     * @return void
     */
    public function setStartDateAttribute($value)
    {
        // Convert datetime picker to carbon date
        $this->attributes['start_date'] = Carbon::parse($value);
    }

    /**
     * Change format from front-end to back-end compatible
     *
     * @param $value
     *
     * @return void
     */
    public function setEndDateAttribute($value)
    {
        // Convert datetime picker to carbon date
        $this->attributes['end_date'] = Carbon::parse($value);
    }

    /**
     * Return start and end date combined
     *
     * @return string
     */
    public function getPeriodAttribute(): string
    {
        return Carbon::parse($this->attributes['start_date'])->format('d-m-Y') . ' - ' . Carbon::parse($this->attributes['end_date'])->format('d-m-Y');
    }

    /**
     * Change format from back-end to front-end compatible
     *
     * @return string
     */
    public function getStartDateAttribute(): string
    {
        return Carbon::parse($this->attributes['start_date'])->format('m-d-Y');
    }

    /**
     * Change format from back-end to front-end compatible
     *
     * @return string
     */
    public function getEndDateAttribute(): string
    {
        return Carbon::parse($this->attributes['end_date'])->format('m-d-Y');
    }
}
