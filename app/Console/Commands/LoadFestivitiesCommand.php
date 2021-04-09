<?php

namespace App\Console\Commands;

use App\Models\Festivity;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoadFestivitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'festivities:load {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Festivities from xml file';

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
        if (Festivity::count() === 0) {
            $this->setupFestivities();
        } else {
            $this->warn('Already initialized database');
        }
        return 0;
    }

    private function readXMLFile()
    {
        $file = $this->option('file') ?? base_path('festivities.xml');
        $xml = simplexml_load_file($file);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        return $array['festivity'];
    }

    private function getValidRecords($data)
    {
        return Arr::where($data, function ($value) {
            $validation = Validator::make($value, [
                'name' => 'required|string|max:255',
                'place' => 'required|string|max:255',
                'start' => 'required|before:end|date_format:Y-m-d\TH:i:s.v\Z',
                'end' => 'required|after:start|date_format:Y-m-d\TH:i:s.v\Z',
            ]);
            return !$validation->fails();
        });
    }

    private function setupFestivities()
    {
        try {
            $data = $this->readXMLFile();
            $validatedData = $this->getValidRecords($data);

            $this->info("Initializing database!!!");

            $toInsert = count($validatedData);
            $possible = count($data);
            $errors = $possible - $toInsert;

            $this->info("{$toInsert} valid records from {$possible} were found");
            $this->info("Inserting valid records...");

            DB::beginTransaction();
                $this->output->progressStart($toInsert);
                foreach ($validatedData as $festivity) {
                    Festivity::create($festivity);
                    $this->output->progressAdvance();
                }
                $this->output->progressFinish();
            DB::commit();

            $this->error("{$errors} errors found");
        } catch (Exception $e) {

            $this->error('Error Initialized database, restoring ...');
            $this->error($e->getMessage());
            DB::rollBack();
        }
    }
}
