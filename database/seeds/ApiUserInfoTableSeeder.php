<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 5:48 AM
 */

use App\API\Models\UserInfo;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ApiUserInfoTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        UserInfo::create([
            'full_name' => $faker->name,
            'mobile' => $faker->phoneNumber,
            'apiuser_id' => 1,
        ]);
    }

}