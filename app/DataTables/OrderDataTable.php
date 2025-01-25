<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
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
            ->addColumn('user_name', function ($row) {
                return ($row->user->name!= '')?$row->user->name:'';
            })
            ->addColumn('shopname', function ($row) {
                return ($row->user->shopname!= '')?$row->user->shopname:'';
            })
            ->addColumn('action', function($row){
                // Update Button
                $updateButton = '<a href="'.route('orders.view',["id" => encrypt($row->id)]).'" class="btn btn-info btn-sm manage-customer-edit edit" data-id="'.encrypt($row->id).'" data-name="'.$row->name.'">
                <i class="fa-solid fa-circle-info"></i>
                            </a>';
                return $updateButton;
           })
            ->rawColumns(['action', 'shopname','user_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
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
                    ->setTableId('order-table')
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
            Column::make('user_name'),
            Column::make('shopname'),
            Column::make('total'),
            Column::make('payment_method'),
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
        return 'Order_' . date('YmdHis');
    }
}
