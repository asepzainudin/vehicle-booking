<?php

namespace App\Vendor\DataTables;

class EloquentDataTable extends \Yajra\DataTables\EloquentDataTable
{
    protected string $countColumn = '*';

    public function countColumn(string $column = '*'): static
    {
        $this->countColumn = $column;
        return $this;
    }

    public function count(): int
    {
        return $this->prepareCountQuery()->count($this->countColumn);
    }
}
