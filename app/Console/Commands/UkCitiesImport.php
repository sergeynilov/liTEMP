<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;

// app/Imports/UkCitiesImport.php
use App\Imports\UkCitiesImportClass;
use Maatwebsite\Excel\Excel;


class UkCitiesImport extends Command
{
    /**
     * The name and signature of the console command.
     * php artisan  command:UkCitiesImport
     * @var string
     */
    protected $signature = 'command:UkCitiesImport';
    // php artisan make:command UkCitiesImport


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

        $import = new UkCitiesImportClass();
        \Excel::import($import, public_path().'/csv/postcodes.csv');
        return 0;
    }
}
