<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Brand extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'display_order',
        'active',
    ];
}
