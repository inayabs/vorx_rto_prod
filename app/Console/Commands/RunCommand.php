<?php

namespace App\Console\Commands;

use App\Http\Controllers\Master\MasterController;
use App\Http\Controllers\StudentClass\TimeTableController;
use Illuminate\Console\Command;

class RunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:command {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run specific command for testing...';

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
        dump('=====================================================');
        // dump('CHECKING MODULE.....');
        // dump('');
        

        if($this->argument('module') == 'timetable') {
            dump('ACCESS '. strtoupper($this->argument('module')));
            dump('=====================================================');
            $tt = new TimeTableController;
            
            $tt->generate_time_table();
        }


        if($this->argument('module') == 'update_student_created_at') {
            dump('ACCESS '. strtoupper($this->argument('module')));
            dump('=====================================================');
            $u = new MasterController;

            $u->update_student_created_at();
        }

        dump('=====================================================');
    }
}
