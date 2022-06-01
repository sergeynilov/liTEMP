<?php

namespace App\Imports;

//use App\Models\User;
use App\Models\City;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithStartRow;

class CitiesImport implements ToModel, WithStartRow
{

    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //          \Excel::import(new CitiesImport, public_path('/csv/city.csv'));
//        \Log::info(  varDump($row, ' -1 CitiesImport $row::') );
        return new City([ // https://www.remotestack.io/how-to-import-export-excel-and-csv-file-in-laravel-application/
                        'address'     => $row[0],
                        'postal_code'     => $row[1],
                        'country'    => $row[2],
                        'federal_district' => $row[3],
                        'region_type' => $row[4],
                        'region' => $row[5],
                        'area_type' => $row[6],
                        'area' => $row[7],
                        'city_type' => $row[8],
                        'city' => $row[9],
                        'settlement_type' => $row[10],
                        'settlement' => $row[11],
                        'kladr_id' => $row[12],
                        'fias_id' => $row[13],
                        'fias_level' => $row[14],
                        'capital_marker' => $row[15],
                        'okato' => $row[16],
                        'oktmo' => $row[17],
                        'tax_office' => $row[18],
                        'timezone' => $row[19],

                        'geo_lat' => $row[20],

                        'geo_lon' => $row[21],
                        'population' => $row[22],
                        'foundation_year' => $row[23],
        ]);
    }
}
