<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FixtureCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixture:create {tables}';

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

        $fixturesPath = config('fixtures.location');

        if (!file_exists($fixturesPath)) {
            mkdir($fixturesPath);
        }

        foreach ($tables as $table) {
            $file = fopen($fixturesPath . '/' . $table . '.csv', 'w');

            \DB::table($table)->orderBy('id')->chunk(100, function (Collection $rows) use ($file) {
                static $first = true;
                foreach ($rows as $row) {
                    $row = (array)$row;
                    if ($first) {
                        fputcsv($file, array_keys($row));
                        $first = false;
                    }

                    fputcsv($file, array_values($row));
                }
            });

            fclose($file);
        }
    }
}
