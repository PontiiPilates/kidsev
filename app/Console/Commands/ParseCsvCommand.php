<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;

class ParseCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $csv = Reader::createFromPath(storage_path('/app/uploads/hw-pool.csv'), 'r');
        $csv->setDelimiter(';');


        $records = $csv->getRecords();

        foreach ($records as $record) {
            dump($records);
        }


        return 0;
    }
}
