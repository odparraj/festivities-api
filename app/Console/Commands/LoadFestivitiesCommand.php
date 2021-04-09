<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\FestivitiesController;
use App\Models\Festivity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Orion\Http\Requests\Request;

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
        if (Festivity::count() == 0) {
            try {
                DB::beginTransaction();

                $file = $this->option('file') ?? base_path('festivities.xml');
                $xml = simplexml_load_file($file);
                $json = json_encode($xml);
                $array = json_decode($json, true);

                $request = app(Request::class)->merge([
                    'resources' => $array['festivity']
                ]);

                app(FestivitiesController::class)->batchStore($request);

                DB::commit();

                $this->info("Initialized database!!!");
                
            } catch (\Exception $e) {

                $this->error('Error Initialized database, restoring ...');
                $this->error($e->getMessage());
                DB::rollBack();
            }
        } else {
            $this->warn('Already initialized database');
        }
        return 0;
    }
}
