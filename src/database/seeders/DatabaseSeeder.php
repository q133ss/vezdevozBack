<?php

namespace Database\Seeders;

use App\Models\Column;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $columns = [
            'Колонка 1' => 1,
            'Колонка 2' => 2
        ];

        foreach ($columns as $name => $position)
        {
            Column::create(['name' => $name, 'position' => $position]);
        }

        $tasks = [
            [
                'column_id' => 1,
                'name' => 'Задача 1',
                'position' => 1
            ],
            [
                'column_id' => 1,
                'name' => 'Задача 2',
                'position' => 2
            ],
            [
                'column_id' => 2,
                'name' => 'Задача 3',
                'position' => 3
            ],
            [
                'column_id' => 2,
                'name' => 'Задача 4',
                'position' => 4
            ],
        ];

        foreach ($tasks as $task)
        {
            Task::create($task);
        }

        $this->command->info('Seed завершен!');
    }
}
