<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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



            ->editcolumn('subcategory_id', function ($data) {
                return $data->getSubCategory ? $data->getSubCategory->subcategory_name : '';
            })

            ->editcolumn('firstname', function ($data) {
                return $data->full_name;
            })

            ->editcolumn('profile', function ($data) {
                return '<img src="' . $data->profile_url . '" height="100px" width="100px">';
            })
            ->addColumn('action', function ($data) {
                $inactive = "";
                if (Auth::user()->is_admin == 1) {

                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-primary m-1 changestatus" status ="0" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-success m-1 changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-unlock"></i></button>';
                }
            }
                if (auth()->user()->hasAnyPermission('user_update')) {
                    $inactive .=  '<button type="button" class="btn btn-warning m-1 update" data-toggle="modal" data-target="#updateuser" id="' . $data->id . '"><i class="fa fa-edit"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('user_delete')) {
                    $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('user_address_create')) {
                $inactive .=  '<a href="' . route('admin.address.edit', $data->id) . '" class="btn btn-success btn-sm  m-1 editdata" id="' . $data->id . '" title="Edit Page"><i class="fa fa-edit"></i></a>';
                }
                if (auth()->user()->hasAnyPermission('user_document_create')) {
                    $inactive .=  '<button type="button" class="btn btn-primary m-1 adddoc" data-toggle="modal" data-target="#adddoc" id="' . $data->id . '"><i class="fa fa-plus"></i></button>';
                }
                return $inactive;
            })
            // ->addColumn('profile', function ($data) {
            //     if ($data->profile == '') {
            //         return '<img src="images/default/default.jpg" height="50px" width="50px"height="50px" width="50px"/>';
            //     } else {
            //         return '<img src="' . '/images/' . $data->profile . '"height="50px" width="50px"/>';
            //     }
            // })
            ->rawColumns(['action', 'status', 'profile', 'first_name'])
            ->addIndexColumn();
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
            Column::make('profile'),
            Column::make('firstname')->title('Fullname'),
            // Column::make('firstname')->searchable(),
            // Column::make('lastname')->searchable(),
            Column::make('email')->searchable(),
            Column::make('category_id')->searchable()->title('Category'),
            Column::make('subcategory_id')->searchable()->title('SubCategory'),
            Column::make('created_at')->title('register date'),
            Column::make('updated_at'),
            Column::make('status'),


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
