<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 5:34 AM
 */


use App\API\Models\User;
use Illuminate\Database\Seeder;

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