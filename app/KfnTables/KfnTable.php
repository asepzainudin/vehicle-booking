<?php

namespace App\KfnTables;

use App\Enums\KfnRowAction;
use Illuminate\Support\Fluent;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KfnTable extends DataTable
{
    /** @var string */
    protected string $tableId = 'kfn-table';

    /** @inheritdoc */
    protected string $dataTableVariable = 'kfnTable';

    /** @var Fluent */
    protected Fluent $routeParams;

    /** @var bool */
    private bool $usingKfnAjax = false;

    /** @var array */
    private array $kfnAjax = [];

    public function __construct()
    {
        parent::__construct();
        $this->routeParams = new Fluent($this->request->route()->parameters());
        Builder::useVite();
    }

    protected function emptyTable(): DataTableAbstract
    {
        return (new CollectionDataTable(collect()));
    }

    protected function getIndexColumn(): Column
    {
        return Column::make('DT_RowIndex')->title(' #&nbsp;')
            ->addClass('text-end text-nowrap')
            ->width('2%')
            ->orderable(false)
            ->searchable(false);
    }

    protected function getJsNamespace(): string
    {
        return config('datatables-html.namespace', 'LaravelDataTables');
    }

    protected function getHtmlBuilder(): Builder
    {
        $builder = $this->handleHtml();

        if (is_callable($this->htmlCallback)) {
            app()->call($this->htmlCallback, compact('builder'));
        }

        view()->share([
            'kfnTableNamespace' => $this->getJsNamespace(),
            $this->dataTableVariable => $builder,
        ]);

        return $builder;
    }

    public function minifiedAjax(
        string $url = '',
        string|null $script = null,
        array $data = [],
        array $ajaxParameters = []
    ): void {
        $this->kfnAjax = [
            'url' => $url,
            'script' => $script,
            'data' => $data,
            'ajaxParameters' => $ajaxParameters,
        ];
    }

    private function handleHtml(): Builder
    {
        $builder = $this->html();

        if (method_exists(static::class, 'getColumns')) {
            $builder->columns($this->getColumns());
        }

        if ($this->usingKfnAjax) {
            $builder->minifiedAjax(
                url: $this->kfnAjax['url'],
                script: $this->kfnAjax['script'],
                data: array_merge($this->request->input(), $this->kfnAjax['data']),
                ajaxParameters: $this->kfnAjax['ajaxParameters'],
            );
        }

        if ($this->request->input('kfn_search')) {
            $builder->search(['search' => $this->request->input('kfn_search')]);
        }

        if (is_numeric($pageLength = $this->request->input('kfn_length'))) {
            $builder->pageLength($pageLength);
        }

        return $builder;
    }

    public function getRowActions(
        string $baseRouteName,
        string|array $routeParam = [],
        array $actions = [],
        string|null $deleteConfirm = null
    ): string {

        $delConfirm = $deleteConfirm ?: 'yakin menghapus record ini ?';
        $actionMenu = [];
        if (is_string($routeParam)) {
            $routeParams = [$routeParam];
        }
        if (empty($routeParams)) {
            $routeParams = [];
        }

        foreach ($actions as $key => $value) {
            if (is_integer($key)) {
                $action = KfnRowAction::tryFrom($value);
                $link = routed($baseRouteName.'.'.$value, $routeParams);
                $icon = xIcon($value) ?: '<span></span>';
                $label = $action->label();
            } else {
                $action = KfnRowAction::tryFrom($key);
                $link = routed($baseRouteName.'.'.$key, $routeParams);
                $icon = xIcon($key) ?: '<span></span>';
                $label = $value;
            }
            if (KfnRowAction::DELETE == $action) {
                $actionMenu[] = "<li><a href='javascript:void(0)' class='btn-delete dropdown-item d-flex align-items-center gap-2' data-href='{$link}' data-action='window.{$this->getJsNamespace()}[\"{$this->tableId}\"].ajax.reload()' data-confirm-text='{$delConfirm}'>{$icon}<span>{$label}</span></a></li>";
            } else {
                $actionMenu[] = "<li><a href='{$link}' class='dropdown-item d-flex align-items-center gap-2'>{$icon}<span>{$label}</span></a></li>";
            }
        }

        return "<div class='dropdown dropdown-action'>".
            "<button type='button' class='btn btn-icon btn-sm btn-outline btn-outline-dashed' data-bs-toggle='dropdown' aria-expanded='false'><i class='ki-solid ki-dots-vertical fs-2'></i></button>".
            "<ul class='dropdown-menu dropdown-menu-end'>".
            (implode('', $actionMenu)).
            "</ul>".
            "</div>";
    }
}
