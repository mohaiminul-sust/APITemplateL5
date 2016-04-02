<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 5:34 AM
 */

namespace database\seeds;


use app\API\Models\User;
use Illuminate\Database\Seeder;
use Hash;

class ApiUserTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'ratulcse27@gmail.com',
            'password' => Hash::make('a')
        ]);
    }
}