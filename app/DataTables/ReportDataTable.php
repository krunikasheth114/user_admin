<?php

namespace App\DataTables;

use App\Models\Report;
use App\Exports\ProductsExport;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReportDataTable extends DataTable
{
    protected $exportClass = ProductsExport::class;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            // ->addCheckbox()
            // ->selectable()
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" name="report_id[]" class="report_id" id="report_id" value="' . $data->id . '">';
            })
            ->rawColumns(['checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ReportDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Report $model)
    {
        $from = $this->request()->get('start_date');
        $to = $this->request()->get('end_date');
        $query  = $model->newQuery();
        if (!empty($from) && !empty($to)) {
            $time1 = Carbon::parse($from)->format('h:i:s');
            $time2 = Carbon::parse($to)->format('h:i:s');
            $getFilterReport  = $query->whereBetween('time', [$time1, $time2])->get();
        } 
        return  $query;

        // dd($getFilterReport);

    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('reportdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lfrtip')
            ->addCheckbox()
            ->orderBy(1);
        // ->buttons([
        //     'csv',
        //     'excel',
        //     'pdf',
        // ]);
        // ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('checkbox')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('id'),
            Column::make('date'),
            Column::make('time'),
            Column::make('data_1'),
            Column::make('data_2'),
            Column::make('data_3'),
            Column::make('data_4'),
            Column::make('data_5'),
            Column::make('data_6'),
            Column::make('data_7'),
            Column::make('data_8'),
            Column::make('data_9'),
            Column::make('data_10'),
            Column::make('data_11'),
            Column::make('data_12'),
            Column::make('data_13'),
            Column::make('data_14'),
            Column::make('data_15'),
            Column::make('data_16'),
            Column::make('data_17'),
            Column::make('data_18'),
            Column::make('data_19'),
            Column::make('data_20'),
            Column::make('created_at'),
            Column::make('updated_at'),
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Report_' . date('YmdHis');
    }
}
