<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\P_Rentan;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$faker = Faker::create('id_ID');

    	for ($i=1; $i <= 1000000; $i++) {
    		// $date = $faker->date('Y-m-d', '-65 years', '-18 years');
    		// $formattedDate = date('M d, Y', strtotime($date));
    		// $date = Carbon::parse()->format('d-m-Y');

    		\DB::table('p_rentan')->insert([
    			'yayasan_id' => $faker->randomElement([1,2,3,4,5,6]),
    			'kategori_pr_id' => $faker->randomElement([1,2,3,4,5]),
    			'nik' => $faker->unique()->numberBetween(3216027009970009, 3216027019970009),
    			'name' => $faker->name,
    			'address' => $faker->address,
    			'gender' => $faker->randomElement(['male', 'female']),
    			'ttl' => $faker->randomElement(['Jakarta, 21 februari 1999', 'bekasi, 30 september 1997','tangerang, 19 oktober 1987','depok, 19  maret 2000','bogor, 17 april 1977']),
    			// 'phone' => $faker->unique()->numberBetween(62812345500, 62812346000)
    		]);
    	}
    }
}
