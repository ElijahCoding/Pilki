<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixtureImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixture:import {tables} {--truncate : Truncate tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = explode(',', $this->argument('tables'));

        foreach ($tables as $table) {
            $filename = config('fixtures.location') . '/' . $table . '.csv';

            if (!file_exists($filename)) {
                throw new \Exception('file not found');
            }

            if (!$file = fopen($filename, 'r')) {
                throw new \Exception('file not opened');
            }

            \Schema::disableForeignKeyConstraints();

            if ($this->option('truncate')) {
                \DB::table($table)->truncate();
            }

            \DB::beginTransaction();
            try {
                $header = null;
                while (!feof($file)) {
                    if (is_null($header)) {
                        $header = fgetcsv($file);
                        continue;
                    }

                    if ($data = fgetcsv($file)) {
                        \DB::table($table)->insert(array_combine($header, $data));
                    }
                }

                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
            \Schema::enableForeignKeyConstraints();

        }
    }
}
