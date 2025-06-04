<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $connection = config('database.default');

        if ($connection === 'mysql') {
            $filePath = base_path('database/sql/countries.sql');
        }

        if ($connection === 'sqlite') {
            $filePath = base_path('database/sql/countries_sqlite.sql');
        }

        if (! isset($filePath) || ! file_exists($filePath)) {
            $this->command->error('Countries SQL file not found at: '.($filePath ?? 'Unknown path'));

            return;
        }

        $sql = file_get_contents($filePath);

        if (empty($sql)) {
            $this->command->error('Could not read countries SQL file');

            return;
        }

        // Execute the SQL queries
        DB::unprepared($sql);

        $this->command->info('Countries seeded successfully');
    }
}
