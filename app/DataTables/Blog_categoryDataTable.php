<?php

namespace App\DataTables;

use App\Models\Blog_category;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class Blog_categoryDataTable extends DataTable
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
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('Y-m-d H:i:s'); // human readable format
            })
            ->editColumn('updated_at', function ($request) {
                return $request->created_at->format('Y-m-d H:i:s'); // human readable format
            })
            ->editcolumn('status', function ($data) {
                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<span class="btn btn-primary">Active</span>';
                } else {
                    $inactive .= '<span class="btn btn-danger">InActive</span>';
                }
                return $inactive;
            })
            ->addColumn('action', function ($data) {
                $inactive = "";
                if (Auth::user()->is_admin == 1) {

                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-primary m-1 changestatus" status ="0" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-success   m-1 changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-unlock"></i></button>';
                }
            }

                if (auth()->user()->hasAnyPermission('blog_category_update')) {
                    $inactive .=  '<button type="button" class="btn btn-warning m-1  edit " data-toggle="modal" data-target="#edit_blog_category" id="' . $data->id . '"><i class="fa fa-edit"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('blog_category_delete')) {
                    $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
                }
                return $inactive;
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Blog_category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Blog_category $model)
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
            ->setTableId('blog_category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->orderBy(1)
            ->parameters([
                'dom'          => 'Blfrtip',
                'buttons'      => ['excel', 'csv'],
            ]);
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
            Column::make('category'),

            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('status'),
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
        return 'Blog_category_' . date('YmdHis');
    }
}
