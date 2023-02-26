<?php

namespace App\Imports;

use App\Models\Report;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportsImport implements  ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $createdAt = Carbon::createFromFormat('d-m-Y', $row['date']);
        $createdAt = $createdAt->format('Y-m-d H:i:s');
        // dd($createdAt);
        return new Report([
            'date' =>$createdAt,
            'time' =>$row['time'],
            'data_1' =>$row['data_1'],
            'data_2' =>$row['data_2'],
            'data_3' =>$row['data_3'],
            'data_4' =>$row['data_4'],
            'data_5' =>$row['data_5'],
            'data_6' =>$row['data_6'],
            'data_7' =>$row['data_7'],
            'data_8' =>$row['data_8'],
            'data_9' =>$row['data_9'],
            'data_10' =>$row['data_10'],
            'data_11' =>$row['data_11'],
            'data_12' =>$row['data_12'],
            'data_13' =>$row['data_13'],
            'data_14' =>$row['data_14'],
            'data_15' =>$row['data_15'],
            'data_16' =>$row['data_16'],
            'data_17' =>$row['data_17'],
            'data_18' =>$row['data_18'],
            'data_19' =>$row['data_19'],
            'data_20' =>$row['data_20'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
}
