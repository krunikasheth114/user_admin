<?php

namespace App\DataTables;

use App\Models\Like;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LikeDataTable extends DataTable
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
            ->editcolumn('Likes', function ($data) {
                return $data->likes;
            })
            ->editcolumn('blog_id', function ($data) {
                return $data->getBlog->title ;
            })
            ->editcolumn('user_id', function ($data) {
                return $data->getUser ? $data->getUser->firstname . '  ' .  $data->getUser->lastname : '';;
            });
          
          
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Like $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Like $model)
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
                    ->setTableId('like-table')
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
            Column::make('user_id')->title('User Name'),
            Column::make('blog_id')->title('Blog Title')
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
        return 'Like_' . date('YmdHis');
    }
}
