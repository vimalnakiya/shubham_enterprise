<?php

namespace App\DataTables;

use App\Models\Product;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
            ->addColumn('image', function ($row) {
                return '<img src="'.asset("storage/".$row->image).'" class="table-audio-img">';
            })
            ->addColumn('action', function($row){
                
                $action = '<button type="button" class="btn btn-info addStock" data-id="'.encrypt($row->id).'" data-name="'.$row->name.'"  data-quantity="'.$row->quantity.'" data-bs-toggle="modal" data-bs-target="#addStock">
                            <i class="fa-regular fa-square-plus"></i>
                        </button>
                            
                            <a href="#" class="btn btn-primary edit" data-id="'.$row->id.'" >
                    <i class="ri-edit-box-fill"></i>
                    </a>

                    <button type="button" class="btn btn-danger deleteBook" data-id="'.encrypt($row->id).'" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="ri-delete-bin-5-fill"></i>
                    </button>';
                            
                
                return $action;
            })
            ->rawColumns(['action','image']);
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
                    ->setTableId('product-table')
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
            Column::make('price'),
            Column::make('quantity')->title('Available Stock'),
            Column::make('image'),
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
        return 'Product_' . date('YmdHis');
    }
}
