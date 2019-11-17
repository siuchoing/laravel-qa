<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //factory(App\User::class, 3)->create();
        factory(App\User::class, 3)->create()->each(function($one_user) {
            // reference to function of User Model
            $one_user->questions()
                ->saveMany(
                    factory(App\Question::class, rand(1,5))->make()
                );

        });
        //factory(App\Question::class, 10)->create();
        // create() method will insert to database 保存到數據庫
        // make() method will generate object and storage memory 創建模型的新實例
    }
}
