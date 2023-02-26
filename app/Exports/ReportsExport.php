<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings,WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }


    public function collection()
    {
        $query = Report::whereIn('id', $this->id)->get();
        return $query;
    }

    public function headings(): array
    {
        return [
            "no", "date", "time", "data_1", "data_2", "data_3", "data_4", "data_5",
            "data_6", "data_7", "data_8", "data_9", 'data_10',
            "data_11", "data_12", "data_13", "data_14", "data_15",
            "data_16", "data_17", "data_18", "data_19", "data_20"
        ];
    }
    public function map($data): array
    {
        return [
            !empty($data->id) ? $data->id : '',
            !empty($data->date) ? $data->date : '',
            !empty($data->time) ? $data->time : '',
            !empty($data->data_1) ? $data->data_1 : '',
            !empty($data->data_2) ? $data->data_2 : '',
            !empty($data->data_3) ? $data->data_3 : '',
            !empty($data->data_4) ? $data->data_4 : '',
            !empty($data->data_5) ? $data->data_1 : '',
            !empty($data->data_6) ? $data->data_6 : '',
            !empty($data->data_7) ? $data->data_7 : '',
            !empty($data->data_8) ? $data->data_8 : '',
            !empty($data->data_9) ? $data->data_9 : '',
            !empty($data->data_10) ? $data->data_10 : '',
            !empty($data->data_11) ? $data->data_11 : '',
            !empty($data->data_12) ? $data->data_12 : '',
            !empty($data->data_13) ? $data->data_13 : '',
            !empty($data->data_14) ? $data->data_14 : '',
            !empty($data->data_15) ? $data->data_15 : '',
            !empty($data->data_16) ? $data->data_16 : '',
            !empty($data->data_17) ? $data->data_17 : '',
            !empty($data->data_18) ? $data->data_18 : '',
            !empty($data->data_19) ? $data->data_19 : '',
            !empty($data->data_20) ? $data->data_20 : '',
          
        ];
    }
}
