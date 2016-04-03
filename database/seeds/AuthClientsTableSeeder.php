<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 7:23 AM
 */
use Illuminate\Database\Seeder;

class AuthClientsTableSeeder extends Seeder
{
    public function run()
    {
        $clients = [
            [
                'id' => 'Wz0A5QM0Q3QSPO8L',
                'name' => 'job-search-bd',
                'secret' => 'qHjNcvo67zaRRFka406MBMItF5Rmqbnf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        DB::table('oauth_clients')
            ->insert($clients);
    }
}