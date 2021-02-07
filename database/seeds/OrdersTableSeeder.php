<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('orders');
        $table->truncate();
        $table->insert([
            [
                'user_id' => 1,
                'address_id' => 1,
                'order_code' => 'X2021-0203001',
                'status' => 1,
                'fix_date' => null,
                'delivery_completed_date' => null,
                'created_at' => '2021-01-31 23:59:59',
                'updated_at' => '2021-01-31 23:59:59'
            ],
            [
                'user_id' => 1,
                'address_id' => 2,
                'order_code' => 'X2021-0203002',
                'status' => 2,
                'fix_date' => '2021-01-02 12:00:00',
                'delivery_completed_date' => null,
                'created_at' => '2021-02-01 00:00:00',
                'updated_at' => '2021-02-01 00:00:00'
            ],
        ]);

        $table = DB::table('order_items');
        $table->truncate();
        $table->insert([
            [
                'order_id' => 1,
                'item_id' => 1,
                'price' => 298,
                'created_at' => '2021-01-01 10:00:00',
                'updated_at' => '2021-01-01 10:00:00'
            ],
            [
                'order_id' => 2,
                'item_id' => 1,
                'price' => 298,
                'created_at' => '2021-02-01 10:00:00',
                'updated_at' => '2021-02-01 10:00:00'
            ],
            [
                'order_id' => 2,
                'item_id' => 2,
                'price' => 198,
                'created_at' => '2021-02-01 10:00:00',
                'updated_at' => '2021-02-01 10:00:00'
            ],
            [
                'order_id' => 2,
                'item_id' => 2,
                'price' => 198,
                'created_at' => '2021-02-01 10:00:00',
                'updated_at' => '2021-02-01 10:00:00'
            ],
        ]);
    }
}
