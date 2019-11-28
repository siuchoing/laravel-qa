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
        $this->call([
            UsersQuestionAnswerTableSeeder::class,
            FavoritesTableSeeder::class,
            VotablesTableSeeder::class
        ]);
    }
};
