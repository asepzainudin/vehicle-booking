<?php

namespace App\KfnTables;

use Illuminate\Support\Fluent;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class WowTable extends \Yajra\DataTables\Services\DataTable
{
    /** @inheritdoc */
    protected string $dataTableVariable = 'KfnTable';

    /** @var Fluent */
    protected Fluent $routeParams;

    private bool $usingWowAjax = false;
    private array $wowAjax = [];

    public function __construct()
    {
        parent::__construct();
        $this->routeParams = new Fluent($this->request->route()->parameters());
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

        view()->share('KfnTableNamespace', $this->getJsNamespace());

        if (is_callable($this->htmlCallback)) {
            app()->call($this->htmlCallback, compact('builder'));
        }

        return $builder;
    }

    public function minifiedAjax(
        string $url = '',
        string|null $script = null,
        array $data = [],
        array $ajaxParameters = []
    ): void {
        $this->wowAjax = [
            'url' => $url,
            'script' => $script,
            'data' => $data,
            'ajaxParameters' => $ajaxParameters,
        ];
    }

    private function handleHtml(): Builder
    {
        $builder = $this->html();

        if ($this->usingWowAjax) {
            $builder->minifiedAjax(
                url: $this->wowAjax['url'],
                script: $this->wowAjax['script'],
                data: array_merge($this->request->input(), $this->wowAjax['data']),
                ajaxParameters: $this->wowAjax['ajaxParameters'],
            );
        }

        if ($this->request->input('wow_search')) {
            $builder->search(['search' => $this->request->input('wow_search')]);
        }

        if (is_numeric($pageLength = $this->request->input('wow_length'))) {
            $builder->pageLength($pageLength);
        }

        return $builder;
    }


}
