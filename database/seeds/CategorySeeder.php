<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        DB::table('category')->insert([
		    ['name' => 'Laravel','created_at' => $date,'updated_at' => $date],
		    ['name' => 'Codeigniter','created_at' => $date,'updated_at' => $date],
		    ['name' => 'HTML','created_at' => $date,'updated_at' => $date],
		    ['name' => 'CSS','created_at' => $date,'updated_at' => $date],
		    ['name' => 'AJAX','created_at' => $date,'updated_at' => $date],
		    ['name' => 'Bootstrap','created_at' => $date,'updated_at' => $date],
        ]);
    }
}
