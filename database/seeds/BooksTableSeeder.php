<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 100) as $index){
            DB::table('books')->insert([
                'title' => $faker->word(),
                'preview' => $faker->sentence(),
                'author_id' => \App\Models\Author::orderByRaw("RAND()")->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ]);
        }
    }
}
