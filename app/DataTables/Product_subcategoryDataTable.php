<?php

namespace App\DataTables;

use App\Models\Product_subcategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class Product_subcategoryDataTable extends DataTable
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
                return $data->getCategory['name'] ?? "no category found";
            })
            ->editcolumn('status', function ($data) {
                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<span class="badge badge-primary">Active</span>';
                } else {
                    $inactive .= '<span class="badge badge-danger">InActive</span>';
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
                        $inactive .= '<button type="button" class="btn btn-primary changestatus" status ="0" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                    } else {
                        $inactive .= '<button type="button" class="btn btn-success changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-unlock"></i></button>';
                    }
              
               
                    $inactive .=  '<button type="button" class="btn btn-warning m-1 edit" data-toggle="modal" data-target="#edit_product_subcategory" id="' . $data->id . '"><i class="fa fa-edit"></i></button>';
                
                    $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
              
                return $inactive;
            })
            ->rawColumns(['action', 'status']);
           }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product_subcategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product_subcategory $model)
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
                    ->setTableId('product_subcategory-table')
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
            Column::make('name'),
            Column::make('category_id'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Product_subcategory_' . date('YmdHis');
    }
}
