<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('admins');
        $table->truncate();
        $table->insert([
            [
                'name' => '田中 太郎',
                'email' => 'tanaka@example.com',
                'password' => bcrypt('12345678'),
                'created_at' => '2021-01-01 10:00:00',
                'updated_at' => '2021-01-01 10:00:00'
            ],
            [
                'name' => '山田 次郎',
                'email' => 'yamada@example.com',
                'password' => bcrypt('12345678'),
                'created_at' => '2021-02-01 10:00:00',
                'updated_at' => '2021-02-01 10:00:00'
            ]
        ]);
    }
}
