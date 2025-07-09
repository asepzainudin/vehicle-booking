<?php

namespace App\KfnTables\Data;

use App\KfnTables\KfnTable;
use App\ModelRules\Data\OfficeRegionMdRule;
use App\Models\OfficeRegion;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class OfficeRegionTable extends KfnTable
{
    public OfficeRegionMdRule $rule;
    protected string $tableId = 'office-region-table';

    public function __construct(OfficeRegionMdRule|null $rule = null)
    {
        parent::__construct();

        $this->rule = $rule instanceof OfficeRegionMdRule
            ? $rule
            : new OfficeRegionMdRule();
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query
     *
     * @return DataTableAbstract
     */
    public function dataTable(QueryBuilder $query): DataTableAbstract
    {
        return kfnTableEloquent($query)
            ->skipAutoFilter()
            ->countColumn('id')
            ->addIndexColumn()
            ->addColumn('name', fn(OfficeRegion $model) => '<a href="' . routed('app.office-region.show', $model->hash) . '" class="fw-bold text-dark">' . $model->name . '</a>')
            ->addColumn('code', fn(OfficeRegion $model) => $model->code)
            ->addColumn('is_active', fn(OfficeRegion $model) => $model->is_active
                        ? '<span class="badge badge-light-success">Aktif</span>'
                        : '<span class="badge badge-light-danger">Non Aktif</span>')
            // ->addColumn('created_by', fn(OfficeRegion $model) => $model->createdBy ? $model->createdBy->name : '-')
            ->addColumn('created', fn(OfficeRegion $model) => carbonFormat($model->created_at, isoFormat: 'L<br>LT'))
            ->addColumn('updated', fn(OfficeRegion $model) => carbonFormat($model->updated_at, isoFormat: 'L<br>LT'))
            ->addColumn('action', function (OfficeRegion $model) {
                $showLink = routed('app.office-region.show', $model->hash_id);
                $editLink = routed('app.office-region.edit', $model->hash_id);
                $delLink = routed('app.office-region.delete', $model->hash_id);
                $dtReload = "window.{$this->getJsNamespace()}[\"{$this->tableId}\"].ajax.reload()";

                $showIcon = "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $editIcon = "<i class='ki-duotone ki-message-edit fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $delIcon = "<i class='ki-duotone ki-trash fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";

                $delConfirm = "yakin menghapus partner {$model->name}?";

                // $buttons = "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-primary me-2' href='{$showLink}'>";
                // $buttons .= "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                // $buttons .= "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-success me-2' href='{$editLink}'>";
                // $buttons .= "<i class='ki-duotone ki-message-edit fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                // $buttons .= "<a href='#' class='menu-link px-3' data-kt-office-region-id='{ $model->hash_id }' data-kt-action='delete_row'>";
                // $buttons .= "<i class='ki-duotone ki-trash fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";


                $buttons = "<div class='dropdown'>";
                $buttons .= "<button type='button' class='btn btn-icon btn-sm btn-outline btn-outline-dashed' data-bs-toggle='dropdown' aria-expanded='false'>";
                $buttons .= "<i class='ki-solid ki-dots-vertical fs-2'></i>";
                $buttons .= "</button>";
                $buttons .= "<ul class='dropdown-menu dropdown-menu-end'>";
                $buttons .= "<li><a href='{$showLink}' class='dropdown-item d-flex align-items-center gap-2'>{$showIcon}<span>Lihat</span></a></li>";
                $buttons .= "<li><a href='{$editLink}' class='dropdown-item d-flex align-items-center gap-2'>{$editIcon}<span>Ubah</span></a></li>";
                $buttons .= "<li><a href='javascript:void(0)' class='dropdown-item d-flex align-items-center gap-2 btn-delete' data-href='{$delLink}' data-action='{$dtReload}' data-confirm-text='{$delConfirm}'>{$delIcon}<span>Hapus</span></a></li>";
                $buttons .= "</ul>";
                $buttons .= "</div>";

                return $buttons;
            })
            ->rawColumns(['action', 'code', 'name', 'is_active', 'created_by', 'created', 'updated'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(OfficeRegion $model): QueryBuilder
    {

        $qry = $model->newQuery()
            ->select(
                    'id', 'hash_id', 'code', 'name', 'value', 'additional', 'is_active', 'sort',
                    'created_by', 'updated_by',
                    'created_at', 'updated_at', 'deleted_at'
            )
            ->addSelect('created_at', 'updated_at');

        if ($q = request()->input('search.value')) {
            $qry->where(function (QueryBuilder $qry) use ($q) {
                $qry->where('name', 'ilike', "%{$q}%");
            });
        }

        return $qry;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        // $this->minifiedAjax();

        return $this->builder()
            ->setTableId($this->tableId)
            ->columns($this->getColumns())
            ->selectClassName('')
            ->orderBy(1)
            ->buttons([
                // Button::make('excel'),
                // Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    protected function getColumns(): array
    {
        return [
            $this->getIndexColumn(),
            Column::make('name', 'name')
                ->title('Nama')
                ->addClass('text-start'),
            Column::make('code', 'code')
                ->title('Code')
                ->addClass('text-start text-nowrap'),
            Column::make('is_active', 'is_active')
                ->title('Status')
                ->addClass('text-start'),
            // Column::make('created_by', 'created_by')
            //     ->title('Pembuat')
            //     ->addClass('text-start'),
            Column::make('created', 'created')
                ->title('tanggal')
                ->addClass('text-start'),
            Column::computed('action')->title('')
                ->exportable(false)
                ->printable(false)
                ->width('10')
                ->addClass('text-center text-nowrap'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'office-region_' . date('YmdHis');
    }
}
