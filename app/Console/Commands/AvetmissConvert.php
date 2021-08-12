<?php

namespace App\Console\Commands;

use App\Http\Controllers\Avetmiss\Avetmiss7ConvertController;
use App\Http\Controllers\Avetmiss\AvetmissConvertController;
use Illuminate\Console\Command;

class AvetmissConvert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avetmiss:convert {path} {version=8}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert data from avetmiss files to VORX database. Arguments = {path} {version}';

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
     * @return mixed
     */
    public function handle()
    {
        //

        // dump($this->argument('path'));
        // dump($this->argument('version'));
        if($this->argument('version') == 8){
            dump('Avetmiss 8');
            $avt = new AvetmissConvertController;
            $avt->convert($this->argument('path'));

        }elseif($this->argument('version') == 7) {
            dump('Avetmiss 7');
            $avt = new Avetmiss7ConvertController;
            $avt->convert($this->argument('path'));
        }

        dd('AVETMISS SUCCESSFULLY CONVERTED!!!');
    }
}
