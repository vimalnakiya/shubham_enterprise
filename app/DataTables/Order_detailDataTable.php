<?php

namespace App\DataTables;

use App\Models\Order_detail;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class Order_detailDataTable extends DataTable
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
            ->addColumn('product_name', function ($row) {
                return ($row->product->name!= '')?$row->product->name:'';
            })
            ->rawColumns(['product_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order_detail $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Request $request,Order_detail $model)
    {
        // dd(decrypt($request->id));
        return $model->newQuery()->where('order_id',decrypt($request->id));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('order_detail-table')
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
            Column::make('product_name')->addClass('text-center'),
            Column::make('price'),
            Column::make('quantity'),
            Column::make('subtotal'),
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename():string
    {
        return 'Order_detail_' . date('YmdHis');
    }
}
