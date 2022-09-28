<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\DiscountRange;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();
        $this->call(RegionSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(AccessTypeSeeder::class);


        Discount::factory(random_int(25,30))->create()->each(function($discount) {
            $discount->discount_range()->saveMany(DiscountRange::factory(random_int(1,3))->make());
        });
    }
}
