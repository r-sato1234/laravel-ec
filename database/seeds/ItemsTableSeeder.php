<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('items');
        $table->truncate();
        $table->insert([
            [
                'admin_id' => 1,
                'name' => 'りんご',
                'img' => 'ringo',
                'description' => 'りんごです',
                'price' => 198,
                'tag_for_search' => 'りんご|リンゴ|アップル',
                'created_at' => '2021-01-01 10:00:00',
                'updated_at' => '2021-01-01 10:00:00'
            ],
            [
                'admin_id' => 2,
                'name' => 'みかん',
                'img' => 'mikan',
                'description' => 'みかんです',
                'price' => 298,
                'tag_for_search' => 'みかん|ミカン',
                'created_at' => '2021-01-01 10:00:00',
                'updated_at' => '2021-01-01 10:00:00'
            ],
            [
                'admin_id' => 1,
                'name' => 'いちご',
                'img' => 'itigo',
                'description' => 'いちごです',
                'price' => 298,
                'tag_for_search' => 'いちご|イチゴ',
                'created_at' => '2021-01-01 10:00:00',
                'updated_at' => '2021-01-01 10:00:00'
            ]
        ]);
    }
}
