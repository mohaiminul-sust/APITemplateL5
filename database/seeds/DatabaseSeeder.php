<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $tables = [
            'role_user',
            'permission_role',
            'oauth_session_scopes',
            'oauth_sessions',
            'oauth_scopes',
            'oauth_refresh_tokens',
            'oauth_grant_scopes',
            'oauth_grants',
            'oauth_client_scopes',
            'oauth_client_grants',
            'oauth_client_endpoints',
            'oauth_clients',
            'oauth_auth_code_scopes',
            'oauth_auth_codes',
            'oauth_access_token_scopes',
            'oauth_access_tokens',
            'permissions',
            'roles',
            'forget_password',
            'apiuser',
            'apiuser_info',
            'users',

        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->command->info('...Truncating Tables...');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->command->info($table.' truncated...');
        }

        $this->command->info('...All Tables Truncated Successfully...');

        $this->command->info('...Seeding Initiated...');


        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EntrustTableSeeder::class);
        $this->call(AuthClientsTableSeeder::class);
        $this->call(ApiUserTableSeeder::class);
        $this->call(ApiUserInfoTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Model::reguard();
    }
}
