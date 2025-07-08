<?php

namespace App\KfnTables\UserManagement;

use App\ModelRules\UserManagement\RoleMdRule;
use App\Vendor\DataTables\EloquentDataTable;
use App\Vendor\Permission\Models\Role;
use App\KfnTables\KfnTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class RoleTable extends KfnTable
{
    public RoleMdRule $rule;
    protected string $tableId = 'role-table';

    public function __construct(RoleMdRule|null $rule = null)
    {
        parent::__construct();

        $this->rule = $rule instanceof RoleMdRule
            ? $rule
            : new RoleMdRule();
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
            ->addColumn('name', fn (Role $model) => $model->name)
            ->addColumn('label', fn (Role $model) => $model->label)
            ->addColumn('note', fn (Role $model) => $model->note)
            ->addColumn('action', function (Role $model) {
                $link = routed('app.role.show', $model->hash);

                $buttons = "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-primary' href='{$link}'>";
                $buttons .= "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $buttons .= "</a>";

                return $buttons;
            })
            ->rawColumns(['action', 'name', 'label', 'note'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        $qry = $model->newQuery()
            ->select('id',  'name', 'label', 'note')
            ->addSelect('created_at', 'updated_at');

        $type = 'client';
        if (authPartnerId()) {
            $type = 'partner';
        }

        $qry->where('type', $type);

        if ($q = request()->input('search.value')) {
            $qry->where(function (QueryBuilder $qry) use ($q) {
                $qry->where('name', 'ilike', "%{$q}%")
                    ->orWhere('label', 'ilike', "%{$q}%");
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
            Column::make('label', 'label')
                ->title('Label')
                ->addClass('text-start text-nowrap'),
            Column::make('note', 'note')
                ->title('Catatan')
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
        return 'test_' . date('YmdHis');
    }
}
