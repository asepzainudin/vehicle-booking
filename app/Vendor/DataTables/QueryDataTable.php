<?php

namespace App\Vendor\DataTables;

class QueryDataTable extends \Yajra\DataTables\QueryDataTable
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
