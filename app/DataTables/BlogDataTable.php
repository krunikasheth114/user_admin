<?php

namespace App\DataTables;

use App\Models\Blog;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
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
                return $data->category['category'] ?? "no category found";
            })
            ->editcolumn('user_id', function ($data) {
                return $data->getUser ? $data->getUser->firstname . '  ' .  $data->getUser->lastname : '';;
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('Y-m-d H:i:s'); // human readable format
            })
            ->editColumn('updated_at', function ($request) {
                return $request->created_at->format('Y-m-d H:i:s'); // human readable format
            })
            ->editcolumn('image', function ($data) {
                return '<img src="'.$data->image_url.'" height="100px" width="100px">';
            })
            
             ->rawColumns(['image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Blog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Blog $model)
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
                    ->setTableId('blog-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
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
            Column::make('image'),
            Column::make('user_id')->title('user'),
            Column::make('category_id')->title('category'),
            Column::make('title'),
            Column::make('description')->width(40),
            Column::make('created_at'),
            Column::make('updated_at')
            // Column::computed('action')
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
        return 'Blog_' . date('YmdHis');
    }
}
