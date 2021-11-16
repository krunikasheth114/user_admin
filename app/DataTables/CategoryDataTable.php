<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
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
            ->editcolumn('status', function ($data) {
                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<span class="btn btn-primary">Active</span>';
                } else {
                    $inactive .= '<span class="btn btn-danger">InActive</span>';
                }
                return $inactive;
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('Y-m-d H:i:s'); // human readable format
            })
            ->editColumn('updated_at', function ($request) {
                return $request->created_at->format('Y-m-d H:i:s'); // human readable format
            })

            ->addColumn('action', function ($data) {
                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-primary m-1 changestatus" status ="0" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-success   m-1 changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-unlock"></i></button>';
                }
                $inactive .=  '<button type="button" class="btn btn-warning m-1  edit " data-toggle="modal" data-target="#editcategory" id="' . $data->id . '"><i class="fa fa-edit"></i></button>';

                $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';

                return $inactive;
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bflrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('category_name'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Category_' . date('YmdHis');
    }
}
