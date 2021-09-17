<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Customer\Models\Citizenship;
use Illuminate\Database\Seeder;

class CustomerFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(100)->create()->each(function($item){
            $item->verified_at = now();
            $item->status = 1;
            $item->save();
        });
    }
}
