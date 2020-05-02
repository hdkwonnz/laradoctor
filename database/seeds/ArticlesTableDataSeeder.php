<?php

use App\Article;
use Illuminate\Database\Seeder;

class ArticlesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
	    	Article::create([
	            'title' => str_random(20),
	            'content' => str_random(100)	            
	        ]);
    	}
    }
}
