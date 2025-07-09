<?php

namespace App\KfnTables\Data;

use App\Enums\VehicleType;
use App\KfnTables\KfnTable;
use App\ModelRules\Data\VehicleMdRule;
use App\Models\Mine;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class VehicleTable extends KfnTable
{
    public VehicleMdRule $rule;
    protected string $tableId = 'vehicle-table';

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
            ->addColumn('name', fn(Vehicle $model) => '<a href="' . routed('app.vehicle.show', $model->hash) . '" class="fw-bold text-dark">' . $model->name . '</a>')
            ->addColumn('code', fn(Vehicle $model) => $model->code)
            ->addColumn('type', fn(Vehicle $model) => $model->type ? "<b>" . VehicleType::from($model->type->value)->label() . "</b>"  : '-')
            ->addColumn('total_vehicles', fn(Vehicle $model) => $model->total_vehicles )
            ->addColumn('vehicles_ready', fn(Vehicle $model) => $model->vechicleOrders->count()
                        ? "<span class='badge badge-light-primary'>" . ($model->total_vehicles - $model->vechicleOrders->count()) . "</span>"
                        : "<span class='badge badge-light-secondary'>{$model->total_vehicles}</span>")
            ->addColumn('vehicle_use', fn(Vehicle $model) => $model->vechicleOrders->count()
                        ? "<span class='badge badge-light-danger'>{$model->vechicleOrders->count()}</span>"
                        : "<span class='badge badge-light-secondary'>0</span>")
            ->addColumn('status', fn(Vehicle $model) => $model->status == 'owned' ? 'Milik Perusahaan' : 'Rental')
            ->addColumn('is_active', fn(Vehicle $model) => $model->is_active
                        ? '<span class="badge badge-light-success">Aktif</span>'
                        : '<span class="badge badge-light-danger">Non Aktif</span>')
            // ->addColumn('created_by', fn(Vehicle $model) => $model->createdBy ? $model->createdBy->name : '-')
            ->addColumn('created', fn(Vehicle $model) => carbonFormat($model->created_at, isoFormat: 'L<br>LT'))
            ->addColumn('updated', fn(Vehicle $model) => carbonFormat($model->updated_at, isoFormat: 'L<br>LT'))
            ->addColumn('action', function (Vehicle $model) {
                $showLink = routed('app.vehicle.show', $model->hash_id);
                $editLink = routed('app.vehicle.edit', $model->hash_id);
                $delLink = routed('app.vehicle.delete', $model->hash_id);
                $dtReload = "window.{$this->getJsNamespace()}[\"{$this->tableId}\"].ajax.reload()";

                $showIcon = "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $editIcon = "<i class='ki-duotone ki-message-edit fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $delIcon = "<i class='ki-duotone ki-trash fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";

                $delConfirm = "yakin menghapus kendaraan {$model->name}?";

                // $buttons = "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-primary me-2' href='{$showLink}'>";
                // $buttons .= "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                // $buttons .= "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-success me-2' href='{$editLink}'>";
                // $buttons .= "<i class='ki-duotone ki-message-edit fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                // $buttons .= "<a href='#' class='menu-link px-3' data-kt-vehicle-id='{ $model->hash_id }' data-kt-action='delete_row'>";
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
            ->rawColumns(['action', 'code', 'name', 'type', 'status', 'vehicles_ready', 'total_vehicles', 'vehicle_use', 'is_active', 'created_by', 'created', 'updated'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Vehicle $model): QueryBuilder
    {
        $qry = $model->newQuery()
            ->select(
                'id', 'hash_id', 'code', 'name', 'type', 'status', 'value', 'additional', 'total_vehicles', 'is_active', 'sort',
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
            Column::make('type', 'type')
                ->title('Jenis Kendaraan')
                ->addClass('text-start'),
            Column::make('total_vehicles', 'total_vehicles')
                ->title('Total kendaraan')
                ->addClass('text-start'),
            Column::make('vehicles_ready', 'vehicles_ready')
                ->title('Kendaraan Tersedia')
                ->addClass('text-start'),
            Column::make('vehicle_use', 'vehicle_use')
                ->title('Kendaraan Terpakai')
                ->addClass('text-start'),
            Column::make('status', 'status')
                ->title('Status Kendaraan')
                ->addClass('text-start'),
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
        return 'vehicle_' . date('YmdHis');
    }
}
