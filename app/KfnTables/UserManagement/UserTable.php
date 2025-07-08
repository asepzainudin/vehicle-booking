<?php

namespace App\KfnTables\UserManagement;

use App\Enums\UserType;
use App\ModelRules\UserManagement\UserMdRule;
use App\Models\User;
use App\Vendor\DataTables\EloquentDataTable;
use App\KfnTables\KfnTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class UserTable extends KfnTable
{
    public UserMdRule $rule;
    protected string $tableId = 'user-table';

    public function __construct(UserMdRule|null $rule = null)
    {
        parent::__construct();

        $this->rule = $rule instanceof UserMdRule
            ? $rule
            : new UserMdRule();
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
            ->addColumn('partner', fn (User $model) => $model->partner->name ?? '')
            ->addColumn('name', fn (User $model) => "<a href='". routed('app.user.show', $model->hash) ."' class='text-dark fw-bold'>{$model->name}</a>")
            ->addColumn('username', fn (User $model) => $model->username)
            ->addColumn('phone', fn (User $model) => $model->phone)
            ->addColumn('email', fn (User $model) => $model->email)
            ->addColumn('type', fn(User $model) => $model->type ? UserType::from($model->type->value)->label() : '')
            ->addColumn('status', fn (User $model) => $model->status)
            ->addColumn('created', fn (User $model) => carbonFormat($model->created_at, isoFormat: 'L<br>LT'))
            ->addColumn('updated', fn (User $model) => carbonFormat($model->updated_at, isoFormat: 'L<br>LT'))
            ->addColumn('action', function (User $model) {
                $showLink = routed('app.user.show', $model->hash);
                $editLink = routed('app.user.edit', $model->hash);
                $delLink = routed('app.user.delete', $model->hash);
                $dtReload = "window.{$this->getJsNamespace()}[\"{$this->tableId}\"].ajax.reload()";

                $showIcon = "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $editIcon = "<i class='ki-duotone ki-message-edit fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                $delIcon = "<i class='ki-duotone ki-trash fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";

                $delConfirm = "yakin menghapus user {$model->name}?";

                // $buttons = "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-primary me-2' href='{$showLink}'>";
                // $buttons .= "<i class='ki-duotone ki-eye fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                // $buttons .= "<a class='btn btn-icon btn-sm btn-outline btn-outline-dashed btn-outline-success me-2' href='{$editLink}'>";
                // $buttons .= "<i class='ki-duotone ki-message-edit fs-2'><span class='path1'></span><span class='path2'></span><span class='path3'></span></i>";
                // $buttons .= "</a>";

                // $buttons .= "<a href='#' class='menu-link px-3' data-kt-user-id='{ $model->hash }' data-kt-action='delete_row'>";
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
            ->rawColumns(['action', 'partner', 'name', 'username', 'phone', 'email', 'status', 'created', 'updated'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        $qry = $model->newQuery()
            ->select('id', 'partner_id', 'travel_id', 'name', 'username', 'phone', 'email', 'status', 'type')
            ->addSelect('created_at', 'updated_at')
            ->whereNull('partner_id')
            ->whereNull('travel_id')
            ->where('username', '!=' ,'owner');

        if ($q = request()->input('user_id')) {
            $qry->whereIn('id', $q);
        }

        if ($q = request()->input('search.value')) {
            $qry->where(function (QueryBuilder $qry) use ($q) {
                $qry->where('name', 'ilike', "%{$q}%")
                    ->orWhere('phone', 'ilike', "%{$q}%")
                    ->orWhere('email', 'ilike', "%{$q}%")
                    ->orWhere('username', 'ilike', "%{$q}%");
            });
        }

        $qry->orderBy('partner_id');


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
        $columns = [
            Column::make('name', 'name')
                ->title('Nama')
                ->addClass('text-start'),
            Column::make('username', 'username')
                ->title('Username')
                ->addClass('text-start text-nowrap'),
            Column::make('phone', 'phone')
                ->title('Handphone')
                ->addClass('text-start'),
            Column::make('email', 'email')
                ->title('Email')
                ->addClass('text-start'),
                 Column::make('type', 'type')
                ->title('Tipe')
                ->addClass('text-start'),
            Column::make('status', 'status')
                ->title('Status')
                ->addClass('text-start'),
            Column::make('created', 'created')
                ->title('tanggal')
                ->addClass('text-start'),
            Column::computed('action')->title('')
                ->exportable(false)
                ->printable(false)
                ->width('10')
                ->addClass('text-center text-nowrap'),
        ];

        if (auth()->user()?->hasAnyRole(['super-admin'])) {
            $columns = array_merge(
                [
                    $this->getIndexColumn(),
                    Column::make('partner', 'partner')
                        ->title('Maskapai')
                        ->addClass('text-start'),
                ],
                $columns
            );
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'test_' . date('YmdHis');
    }
}
