<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * factory(App\Question::class, 10)->create();
     * create() method will insert to database 保存到數據庫
     * make() method will generate object and storage memory 創建模型的新實例
     *
     * @return void
     */

    public function run()
    {
        factory(App\User::class, 3)->create()->each(function($u) {
            $u->questions()->saveMany(
                factory(App\Question::class, rand(1, 5))->make()
            )->each(function ($q){
                $q->answers_count()->saveMany(
                    factory(App\Answer::class, rand(1, 5))->make()
                );
            });
        });
    }
};
