<?php

namespace App\Http\Wire;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

class Component extends \Livewire\Component
{
    protected string|null $layout = null;

    /**
     * Component data.
     */
    private array $componentData = [];

    /**
     * Page Meta.
     */
    private array $pageMeta = [
        'description' => '',
        'keywords' => 'yusronarif, koffinate, laravel',
        'author' => 'Yusron Arif <yusron.arif4::at::gmail.com>',
        'generator' => 'Koffinate',
    ];

    public string|null $backLink = null;
    public array $filters = [];
    public array $form = [];

    protected string $viewPrefix = '';

    public function __construct()
    {
        $this->form = array_merge_recursive(request()->input(), $this->form);
    }

    public function validate($rules = null, $messages = [], $attributes = []): array
    {
        [$rules, $messages, $attributes] = $this->providedOrGlobalRulesMessagesAndAttributes($rules, $messages, $attributes);
        $rules = $this->setForm($rules);
        $messages = $this->setForm($messages);
        $attributes = $this->setForm($attributes);

        return parent::validate($rules, $messages, $attributes);
    }

    public function applyFilter(): void
    {
        $this->filters = $this->inputs;
    }

    public function routeTo($route, $parameters = [], $status = 302, $headers = []): RedirectResponse
    {
        return to_route($route, $parameters, $status, $headers);
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

        // if (! Arr::has($this->componentData, 'pageTitle')) {
        //     $this->componentData['pageTitle'] = $this->title ?? 'Untitled';
        //     dd($this->componentData['pageTitle']);
        // }
        // dd($this->componentData['pageTitle']);
        if ($this->viewPrefix) {
            $view = "{$this->viewPrefix}{$view}";
        }

        return view($view, $this->componentData)
            ->title($this->componentData['pageTitle'])
            ->layout($this->layout ?? config('livewire.layout'));
    }

    /**
     * Share Blade View.
     *
     * @return void
     */
    private function share(): void
    {
        if (! Arr::has($this->componentData, 'pageTitle')) {
            $this->setPageTitle($this->pageTitle ?? $this->title ?? 'Untitled');
        }
        // dd(Arr::has($this->componentData, 'pageTitle'));

        $this->setPageMeta('csrf_token', csrf_token());

        // $this->componentData['activeUser'] = auth()->user();
        $this->componentData['pageMeta'] = $this->pageMeta;
        // $this->componentData['breadCrumbs'] = $this->breadCrumbs;

        // $this->componentData['crudType'] = $this->crudType;
        // $this->componentData['viewPath'] = ($this->viewPath ?: $this->prefixView).'.';
        // $this->componentData['route'] = $this->route;
    }

    private function setForm(array $inputs = []): array
    {
        $newOne = [];
        foreach($inputs as $key => $val) {
            $newOne["form.{$key}"] = $val;
        }
        return $newOne;
    }

    /**
     * Set controller data.
     *
     * @param  string  $name
     * @param  mixed  $value
     *
     * @return \App\Http\Wire\Component
     */
    protected function setData(string $name, mixed $value): static
    {
        // if (in_array($name, $this->reservedVariables)) {
        //     throw new Exception("Variable [$name] is reserved by this controller");
        // }
        $this->componentData[$name] = $value;

        return $this;
    }

    /**
     * Set page meta.
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return \App\Http\Wire\Component
     */
    protected function setPageMeta(string $key, mixed $value): static
    {
        $this->pageMeta[$key] = $value;

        return $this;
    }

    /**
     * Set Page title.
     *
     * @param  string  $title
     *
     * @return \App\Http\Wire\Component
     */
    protected function setPageTitle(string $title): static
    {
        $this->componentData['pageTitle'] = $title;

        return $this;
    }

    /**
     * Set Back Link.
     *
     * @param  string  $link
     *
     * @return \App\Http\Wire\Component
     */
    protected function setBackLink(string $link): static
    {
        $this->backLink = $link;
        // $this->componentData['backLink'] = $this->backLink;
        view()->share('backLink', $link);

        return $this;
    }

}
