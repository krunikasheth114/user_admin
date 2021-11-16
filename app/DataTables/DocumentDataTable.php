<?php

namespace App\DataTables;

use App\Models\Document;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DocumentDataTable extends DataTable
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
            
            // ->editColumn('document', function ($request) {
            //     return $request->getDocumentUrlAttribute(); 
            // })
            ->editcolumn('user_id', function ($data) {
                return $data->getUser ? $data->getUser->firstname . '  ' .  $data->getUser->lastname : '';;
            })
            ->addColumn('action', function ($data) {
                $inactive = "";
                $inactive .=  '<a href="' . route('admin.document.edit', $data->id) . '" class="btn btn-success btn-sm  m-1 update" id="' . $data->id . '" title="Edit Page"><i class="fa fa-edit"></i></a>';
                $inactive .=  '<a href="' . route('admin.document.destroy', $data->id) . '" class="btn btn-danger btn-sm  m-1 delete" id="' . $data->id . '" ><i class="fa fa-trash"></i></a>';
                return $inactive;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Document $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Document $model)
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
            ->setTableId('document-table')
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
            Column::make('user_id')->title('User name'),
            Column::make('doc_name'),
            Column::make('doc_num'),
            Column::make('document'),
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
        return 'Document_' . date('YmdHis');
    }
}
