<?php

namespace App\Http\Controllers;

use Dflydev\DotAccessData\Data;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;
use Yajra\DataTables\Contracts\DataTableButtons;

class ControllerWeb extends Controller implements \App\Contracts\ControllerWeb
{
    /**
     * Prefix View Path.
     */
    protected string $viewDomain = '';
    protected string $viewPath = '';
    protected string $viewPrefix = '';

    /**
     * Controller data.
     */
    private array $controllerData = [];

    /**
     * Active menu indicator.
     */
    private array $activeMenu = [];
    private array $activeMenuPack = [];

    /**
     * Page title.
     */
    private string $pageTitle = '';

    /**
     * Page Meta.
     */
    private array $pageMeta = [
        'description' => '',
        'keywords' => 'yusronarif, koffinate, laravel',
        'author' => 'Yusron Arif <yusron.arif4::at::gmail.com>',
        'generator' => 'Koffinate',
    ];

    /**
     * Breadcrumbs Collection.
     *
     * @var Collection
     */
    private Collection $breadCrumbs;

    /**
     * Reserved variable for the controller.
     */
    private array $reservedVariables = ['activeMenu', 'activeMenuPack', 'pageTitle', 'pageMeta'];

    private DataTableButtons|null $KfnTable = null;

    /**
     * class instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->setBreadCrumb([]);

        $this->controllerData['backLink'] = '#';
        $this->controllerData['deleteLink'] = '#';
        $this->controllerData['detailLink'] = '#';
        $this->controllerData['editLink'] = '#';
        $this->controllerData['saveLink'] = '#';
    }

    /**
     * Set BreadCrumb.
     *
     * @param  string|array  $breadcrumb
     *
     * @return static
     */
    protected function setBreadCrumb(string|array $breadcrumb): static
    {
        $bc = collect();
        if (is_string($breadcrumb)) {
            $bc->add($this->breadCrumbFormat(['title' => $breadcrumb, 'url' => '#']));
        } else {
            foreach ((array) $breadcrumb as $k => $v) {
                if (is_string($v)) {
                    $bc->add($this->breadCrumbFormat($breadcrumb));
                    break;
                }
                $bc->add($this->breadCrumbFormat($v));
            }
        }

        $this->breadCrumbs = $bc;
        return $this;
    }

    /**
     * Breadcrumb formatter.
     *
     * @param  array  $breadcrumb
     *
     * @return object
     */
    #[Pure]
    private function breadCrumbFormat(array $breadcrumb): object
    {
        $def = ['title' => '', 'url' => '#'];

        return (object) array_merge($def, Arr::only($breadcrumb, ['title', 'url']));
    }

    /**
     * Serve blade template.
     *
     * @param  string  $view
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function view(string $view): View
    {
        $this->share();

        if ($this->viewDomain) {
            $view = "{$this->viewDomain}::{$view}";
        }

        if ($this->viewPrefix) {
            $view = preg_replace('/(\.)+$/i', '', $this->viewPrefix).'.'.$view;
        }

        if ($this->KfnTable instanceof DataTableButtons) {
            return $this->KfnTable->render($view, $this->controllerData);
        }

        return view($view, $this->controllerData);
    }

    /**
     * Share Blade View.
     *
     * @return void
     */
    private function share(): void
    {
        if (false === array_key_exists('pageTitle', $this->controllerData)) {
            $this->setPageTitle($this->pageTitle ?? 'Untitled');
        }

        $this->controllerData = array_merge(request()->route()->parameters(), $this->controllerData);

        $this->setPageMeta('csrf_token', csrf_token());

        $this->controllerData['activeUser'] = auth()->user();
        $this->controllerData['pageMeta'] = $this->pageMeta;
        $this->controllerData['breadCrumbs'] = $this->breadCrumbs;

        $viewPath = $this->viewPath ?: $this->viewPrefix;
        $viewDomain = $this->viewDomain ? "{$this->viewDomain}::" : '';
        $this->controllerData['viewPath'] = $viewDomain.($viewPath ? "{$viewPath}." : '');
        view()->share('viewPath', $this->controllerData['viewPath']);
    }

    /**
     * Set Page title.
     *
     * @param  string  $title
     *
     * @return static
     */
    protected function setPageTitle(string $title): static
    {
        $this->controllerData['pageTitle'] = $title;
        return $this;
    }

    /**
     * Set page meta.
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return static
     */
    protected function setPageMeta(string $key, mixed $value): static
    {
        $this->pageMeta[$key] = $value;
        return $this;
    }

    /**
     * Set Default Value for Request Input.
     *
     * @param string|array $name
     * @param mixed $value
     * @param bool $force
     *
     * @return void
     * @throws \Throwable
     */
    protected function setDefault(string|array $name, mixed $value = null, bool $force = false): void
    {
        setDefaultRequest($name, $value, $force);
    }

    protected function setTable(DataTableButtons $table): void
    {
        if (request()->ajax() && request()->wantsJson()) {
            $table->render()->send();
            exit();
        }
        $this->KfnTable = $table;
    }

    /**
     * Get controller data.
     *
     * @param  string|null  $name
     * @param  mixed  $default
     * @param  bool  $asFluent
     *
     * @return mixed
     */
    protected function data(string|null $name = null, mixed $default = null, bool $asFluent = false): mixed
    {
        $data = fluent($this->controllerData);

        if ($name) {
            return $data->get($name, $default);
        }

        return $asFluent ? $data : $data->toArray();
    }

    /**
     * Set controller data.
     *
     * @param  string  $name
     * @param  mixed  $value
     *
     * @return static
     *
     * @throws \Exception
     */
    protected function setData(string $name, mixed $value): static
    {
        if (in_array($name, $this->reservedVariables)) {
            throw new Exception("Variable [$name] is reserved by this controller");
        }
        $this->controllerData[$name] = $value;

        return $this;
    }

    /**
     * Set Back Link.
     *
     * @param  string  $link
     *
     * @return static
     */
    protected function setBackLink(string $link): static
    {
        $this->controllerData['backLink'] = $link;
        return $this;
    }

    /**
     * Set Detail Link.
     *
     * @param  string  $link
     *
     * @return static
     */
    protected function setDetailLink(string $link): static
    {
        $this->controllerData['detailLink'] = $link;
        return $this;
    }

    /**
     * Set Delete Link.
     *
     * @param  string  $link
     *
     * @return static
     */
    protected function setDeleteLink(string $link): static
    {
        $this->controllerData['deleteLink'] = $link;
        return $this;
    }

    /**
     * Set Save Link.
     *
     * @param  string  $link
     *
     * @return static
     */
    protected function setSaveLink(string $link): static
    {
        $this->controllerData['saveLink'] = $link;
        return $this;
    }

    /**
     * Set Edit Link.
     *
     * @param  string  $link
     *
     * @return static
     */
    protected function setEditLink(string $link): static
    {
        $this->controllerData['editLink'] = $link;
        return $this;
    }

    /**
     * Set Active Menu.
     *
     * @param  string|array  $menu
     *
     * @return static
     */
    protected function setActiveMenu(string|array $menu): static
    {
        $this->activeMenu = (array) $menu;
        return $this;
    }

    /**
     * Add Active Menu.
     *
     * @param  string|array  $menu
     *
     * @return static
     */
    protected function addActiveMenu(string|array $menu): static
    {
        $this->activeMenu = array_merge($this->activeMenu, (array) $menu);
        return $this;
    }

    /**
     * Add BreadCrumb.
     *
     * @param  string|array  $breadcrumb
     *
     * @return static
     */
    protected function addBreadCrumb(string|array $breadcrumb): static
    {
        if (is_string($breadcrumb)) {
            $this->breadCrumbs->add($this->breadCrumbFormat(['title' => $breadcrumb, 'url' => '#']));
        } else {
            foreach ($breadcrumb as $k => $v) {
                if (is_string($v)) {
                    $this->breadCrumbs->add($this->breadCrumbFormat($breadcrumb));
                    break;
                }
                $this->breadCrumbs->add($this->breadCrumbFormat($v));
            }
        }
        return $this;
    }
}
