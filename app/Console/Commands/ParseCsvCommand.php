<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Day;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Program;
use App\Models\Timetable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Statement;
use stdClass;

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
        $files = Storage::allFiles('/uploads/');

        foreach ($files as $file) {

            $csv = Reader::createFromPath(storage_path("/app/$file"), 'r');
            $csv->setDelimiter(';');
            $csv->setHeaderOffset(0);

            $file = $this->filePathToObject($file);

            $this->line("Парсинг файла: $file->code-$file->type");

            foreach ($csv->getRecords() as $record) {

                $organization = Organization::where('code', $file->code)->first();

                $program = null;
                $event = null;
                switch ($file->type) {
                    case 'timetable':
                        $program = Program::create([
                            'organization_id' => $organization->id,
                            'name' => $record['name'],
                            'age_from' => $record['age_from'],
                            'age_to' => $record['age_to'],
                        ]);
                        break;
                    case 'events':
                        $event = Event::create([
                            'organization_id' => $organization->id,
                            'name' => $record['name'],
                            'age_from' => $record['age_from'],
                            'age_to' => $record['age_to'],
                        ]);
                        break;
                }

                Timetable::create([
                    'day_id' => $record['day'],
                    'program_id' => $program->id ?? null,
                    'event_id' => $event->id ?? null,
                    'organization_id' => $organization->id,
                    'city_id' => $organization->city_id,
                    'district_id' => $organization->district_id,
                    'time_start' => $record['time_start'],
                    'time_end' => $record['time_end'],
                    'date' => $record['date'] ?? null,
                ]);
            }
        }

        $this->info("Парсинг файлов успешно завершён!");

        return 0;
    }

    private function filePathToObject($file)
    {
        $fileName = Str::after($file, '/');
        $fileName = Str::before($fileName, '.');
        $fileName = explode('-', $fileName);

        $file = new stdClass();
        $file->code = $fileName[0];
        $file->type = $fileName[1];

        return $file;
    }
}
