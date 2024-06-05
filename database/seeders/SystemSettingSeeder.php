<?php

namespace Database\Seeders;

use App\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemSetting::create([
        	'name' => 'Tercera',
        	'description' => 'The best medical E-commerce',
        	'address' => 'Kigali Rwanda',
        	'tel' => '+254769195528',
        	'email' => 'kevin.nibeza@gmail.com',
        	'slug' => 'company-info',
            'logo' => asset('frontend/img/logo.png'),
        ]);
    }
}
