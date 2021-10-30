<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->editcolumn('category_id', function ($data) {
                return $data->getCategory ? $data->getCategory->category_name : '';
            })

            ->editcolumn('subcategory_id', function ($data) {
                return $data->getSubCategory ? $data->getSubCategory->subcategory_name : '';
            })
            ->addColumn('action', function ($data) {
                $inactive = "";

                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-primary m-1 changestatus" status ="0" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-success m-1 changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-unlock"></i></button>';
                }
                $inactive .=  '<button type="button" class="btn btn-warning m-1 update" data-toggle="modal" data-target="#updateuser" id="' . $data->id . '"><i class="fa fa-edit"></i></button>';
                $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
                $inactive .=  '<a href="' . route('admin.address.edit', $data->id) . '" class="btn btn-success btn-sm  m-1 editdata" id="' . $data->id . '" title="Edit Page"><i class="fa fa-edit"></i></a>';
                $inactive .=  '<button type="button" class="btn btn-primary m-1 adddoc" data-toggle="modal" data-target="#adddoc" id="' . $data->id . '"><i class="fa fa-plus"></i></button>';
                return $inactive;
            })

            ->addColumn('profile', function ($data) {
                return '<img src="' . '/images/' . $data->profile . '"height="50px" width="50px"/>';
            })
            ->rawColumns(['action', 'profile']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
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
            Column::make('profile'),
            Column::make('firstname')->searchable(),
            Column::make('lastname')->searchable(),
            Column::make('email')->searchable(),
            Column::make('category_id')->searchable()->title('Category'),
            Column::make('subcategory_id')->searchable()->title('SubCategory'),
            // Column::make('created_at')->title('register date'),
            // Column::make('updated_at'),
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
        return 'Users_' . date('YmdHis');
    }
}
