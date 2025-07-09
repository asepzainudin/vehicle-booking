<?php

namespace App\KfnTables\ManageOrder;

use App\Enums\StatusType;
use App\Enums\VehicleType;
use App\KfnTables\KfnTable;
use App\ModelRules\Data\VehicleMdRule;
use App\Models\VehicleOrder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class VehicleOrderTable extends KfnTable
{
    public VehicleMdRule $rule;
    protected string $tableId = 'vehicle-order-table';

    public function __construct(VehicleMdRule|null $rule = null)
    {
        parent::__construct();

        $this->rule = $rule instanceof VehicleMdRule
            ? $rule
            : new VehicleMdRule();
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
            ->addColumn('code', fn(VehicleOrder $model) => $model->code ?? '-' )
            ->addColumn('vehicle', fn(VehicleOrder $model) => '<a href="' . routed('app.vehicle-usage.list', $model->hash) . '" class="fw-bold text-dark">' . $model->vehicle->name . '</a>')
            ->addColumn('driver', fn(VehicleOrder $model) => $model->driver?->name ?? '-' )
            ->addColumn('reviewer', fn(VehicleOrder $model) => $model->reviewer?->name ?? '-' )
            ->addColumn('approver', fn(VehicleOrder $model) => $model->approver?->name ?? '-')
            ->addColumn('status', fn(VehicleOrder $model) => $model->status ? "<b>" . StatusType::from($model->status->value)->label() . "</b>"  : '-')
            ->addColumn('return_date', fn(VehicleOrder $model) => carbonFormat($model->return_date, isoFormat: 'L<br>LT'))
            // ->addColumn('is_active', fn(VehicleOrder $model) => $model->is_active
            //             ? '<span class="badge badge-light-success">Aktif</span>'
            //             : '<span class="badge badge-light-danger">Non Aktif</span>')
            ->addColumn('created_by', fn(VehicleOrder $model) => $model->createdBy ? $model->createdBy->name : '-')
            ->addColumn('created', fn(VehicleOrder $model) => carbonFormat($model->created_at, isoFormat: 'L<br>LT'))
            ->addColumn('updated', fn(VehicleOrder $model) => carbonFormat($model->updated_at, isoFormat: 'L<br>LT'))
            ->addColumn('action', function (VehicleOrder $model) {
                $showLink = routed('app.vehicle-order.show', $model->hash_id);
                $editLink = routed('app.vehicle-order.edit', $model->hash_id);
                $delLink = routed('app.vehicle-order.delete', $model->hash_id);
                $dtReload = "window.{$this->getJsNamespace()}[\"{$this->tableId}\"].ajax.reload()";

                $showIcon = "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $editIcon = "<i class='ki-duotone ki-message-edit fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $delIcon = "<i class='ki-duotone ki-trash fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";

                $delConfirm = "yakin menghapus pemesanan kendaraan {$model->name}?";

                // $buttons = "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-primary me-2' href='{$showLink}'>";
                // $buttons .= "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                // $buttons .= "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-success me-2' href='{$editLink}'>";
                // $buttons .= "<i class='ki-duotone ki-message-edit fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                // $buttons .= "<a href='#' class='menu-link px-3' data-kt-vehicle-order-id='{ $model->hash_id }' data-kt-action='delete_row'>";
                // $buttons .= "<i class='ki-duotone ki-trash fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                $buttons = "<div class='dropdown'>";
                $buttons .= "<button type='button' class='btn btn-icon btn-sm btn-outline btn-outline-dashed' data-bs-toggle='dropdown' aria-expanded='false'>";
                $buttons .= "<i class='ki-solid ki-dots-vertical fs-2'></i>";
                $buttons .= "</button>";
                $buttons .= "<ul class='dropdown-menu dropdown-menu-end'>";
                $buttons .= "<li><a href='{$showLink}' class='dropdown-item d-flex align-items-center gap-2'>{$showIcon}<span>Lihat</span></a></li>";
                if ($model->status == StatusType::REVIEW || $model->status == StatusType::REJECTED) {
                    $buttons .= "<li><a href='{$editLink}' class='dropdown-item d-flex align-items-center gap-2'>{$editIcon}<span>Ubah</span></a></li>";
                }
                
                if ($model->status == StatusType::REVIEW || $model->status == StatusType::REJECTED) {
                    $buttons .= "<li><a href='javascript:void(0)' class='dropdown-item d-flex align-items-center gap-2 btn-delete' data-href='{$delLink}' data-action='{$dtReload}' data-confirm-text='{$delConfirm}'>{$delIcon}<span>Hapus</span></a></li>";

                }
                $buttons .= "</ul>";
                $buttons .= "</div>";

                return $buttons;
            })
            ->rawColumns(['action', 'code', 'vehicle', 'driver', 'reviewer', 'approver', 'status', 'return_date', 'created_by', 'created', 'updated'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(VehicleOrder $model): QueryBuilder
    {
        $qry = $model->newQuery()
            ->select(
                'id', 'hash_id', 'code', 'vehicle_id', 'mine_location_id', 'driver_id', 'reviewer_id', 'approver_id', 'status', 'additional', 'return_date', 'is_active',
                'created_by', 'updated_by',
                'created_at', 'updated_at', 'deleted_at'
            )
            ->addSelect('created_at', 'updated_at');

        if ($q = request()->input('search.value')) {
            $qry->whereHas('vehicle', function($qry) use ($q) {
                $qry->where('name', 'ilike', "%{$q}%");
            });
        }

        $qry->orderByRaw("
            CASE status
                WHEN '" . StatusType::APPROVED->value . "' THEN 1
                WHEN '" . StatusType::REVIEW->value . "' THEN 2
                WHEN '" . StatusType::RETURN->value . "' THEN 3
                WHEN '" . StatusType::REJECTED->value . "' THEN 4
                ELSE 5
            END
        ");

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
            Column::make('code', 'code')
                ->title('Kode')
                ->addClass('text-start'),
            Column::make('vehicle', 'vehicle')
                ->title('Kendaraan')
                ->addClass('text-start'),
            Column::make('driver', 'driver')
                ->title('Driver')
                ->addClass('text-start text-nowrap'),
            Column::make('reviewer', 'reviewer')
                ->title('Reviewer')
                ->addClass('text-start'),
            Column::make('approver', 'approver')
                ->title('Approver')
                ->addClass('text-start'),
            Column::make('status', 'status')
                ->title('Status')
                ->addClass('text-start'),
            Column::make('return_date', 'return_date')
                ->title('Tanggal Kembali')
                ->addClass('text-start'),
            // Column::make('created_by', 'created_by')
            //     ->title('Pembuat')
            //     ->addClass('text-start'),
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
        return 'vehicle-order_' . date('YmdHis');
    }
}
