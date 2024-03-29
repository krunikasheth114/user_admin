<?php

namespace App\DataTables;

use App\Exports\ProductsExport;
use App\Models\Product;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Session;

use AmrShawky\LaravelCurrency\Facade\Currency;


class ProductsDataTable extends DataTable
{
    protected $exportClass = ProductsExport::class;
    // protected $exportColumns = [
    //     ['data' => 'id', 'title' => 'ID'],
    // ];
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
                return $data->getCategory ? $data->getCategory->name : '';
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
            ->editcolumn('subcategory_id', function ($data) {
                return $data->subCategory ? $data->subCategory->name : '';
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
                    $inactive .= '<button type="button" class="btn btn-success m-1 changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-unlock"></i></button>';
                }
                $inactive .=  '<button type="button" class="btn btn-warning m-1 edit" data-toggle="modal" data-target="#update_product" id="' . $data->id . '"><i class="fa fa-edit"></i></button>';
                $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
                return $inactive;
            })
            ->editcolumn('image', function ($data) {
                // $imageUrl = URL::to('/images/') . $data->image;
                // return '<img src="'.$imageUrl.'"height="100px" width="100px />';

                $image = '<img src="' . $data->ImageUrl . '" height="100px" width="100px">';
                return $image;
                // $path = $data->ImageUrl;
                // return '<a href ="' . $path . '" ><img src ="' . $data->ImageUrl . ' "height=150 width="70"/></a>';
                //    return <a href = "' .$data->ImageUrl.'"><img src ="'.$data->ImageUrl.' " height=150" width="70"></a>;
            })
            ->editcolumn('price', function ($data) {
                $from = Session::get('currency');
                $to = 'INR';
                if ($from == 'INR') {
                    $to = 'EUR';
                    $converted = Currency::convert()
                        ->from($from)
                        ->to($to)
                        ->amount((int)$data->price)
                        ->get();
                } else {
                    $converted = $data->price;
                }
                return $converted;
            })
            ->rawColumns(['action', 'status', 'image'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
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
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blfrtip')
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
            Column::make('id')->exportable(true),
            Column::make('category_id')->searchable()->title('Category'),
            Column::make('subcategory_id')->searchable()->title('SubCategory'),
            Column::make('name')->searchable(true),
            Column::make('price')->searchable(),
            Column::make('status'),
            Column::make('image')->exportable(false),
            Column::make('created_at')->searchable(),
            Column::make('updated_at')->searchable(),
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
        return 'Products_' . date('YmdHis');
    }
}
