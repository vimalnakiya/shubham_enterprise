<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $counter = 1;
        return datatables()
            ->eloquent($query)
            ->addColumn('sr_no', function () use (&$counter) {
                return $counter++;
            })
            ->addColumn('shopname', function ($row) {
                return ($row->shopname!='')?$row->shopname:'';
            })
            ->addColumn('mobile', function ($row) {
                return ($row->mobile!='')?$row->mobile:'';
            })
            ->addColumn('email', function ($row) {
                return ($row->email!='')?$row->email:'';
            })
            ->addColumn('action', function($row){
                if($row->status == '0'){
                    $action = '<button type="button" class="btn btn-danger deleteBook" data-id="'.encrypt($row->id).'" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    VERIFY
                    </button>';
                }else{
                    $action = '';
                }
                return $action;
            })
            ->rawColumns(['action','shopname','mobile','email']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->where('role_id',2);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('user-table')
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
            Column::make('sr_no'),
            Column::make('name'),
            Column::make('shopname'),
            Column::make('mobile'),
            Column::make('email'),
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
    protected function filename():string
    {
        return 'User_' . date('YmdHis');
    }
}
