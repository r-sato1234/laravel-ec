<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('users');
        $table->truncate();
        $table->insert([
            [
                'email' => 'yamada@example.com',
                'name' => '山田 太郎',
                'password' => bcrypt('12345678'),
                'created_at' => '2021-01-01 10:00:00',
                'updated_at' => '2021-01-01 10:00:00'
            ],
        ]);

        $table = DB::table('addresses');
        $table->truncate();
        $table->insert([
            [
                'user_id' => 1,
                'prefecture_id' => 13,
                'zip' => '1600022',
                'address' => '東京都新宿区新宿1-1',
                'created_at' => '2021-01-01 10:00:00',
                'updated_at' => '2021-01-01 10:00:00'
            ],
            [
                'user_id' => 1,
                'prefecture_id' => 13,
                'zip' => '1600022',
                'address' => '東京都新宿区新宿2-1',
                'created_at' => '2021-01-01 10:00:00',
                'updated_at' => '2021-01-01 10:00:00'
            ],
        ]);
    }
}
