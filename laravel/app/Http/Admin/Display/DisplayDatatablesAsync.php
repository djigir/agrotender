<?php

namespace App\Http\Admin\Display;

use SleepingOwl\Admin\Contracts\WithRoutesInterface;
use SleepingOwl\Admin\Display\DisplayDatatablesAsync as DisplayDatatablesAsyncBase;

class DisplayDatatablesAsync extends DisplayDatatablesAsyncBase implements WithRoutesInterface
{
    public function __construct($name = null, $distinct = null)
    {
        parent::__construct();
    }


    public function renderAsync(\Illuminate\Http\Request $request)
    {
        $query = $this->getRepository()->getQuery();
        $totalCount = $query->count();
        $filteredCount = 0;

        if (! is_null($this->distinct)) {
            $filteredCount = $query->distinct()->count($this->getDistinct());
        }

        $this->modifyQuery($query);
        $this->applySearch($query, $request);

        if (is_null($this->distinct)) {
            $countQuery = clone $query;
            $countQuery->getQuery()->orders = null;
            $filteredCount = $countQuery->get()->count();
        }

        $this->applyOffset($query, $request);
        $collection = $query->get();

        return $this->prepareDatatablesStructure($request, $collection, $totalCount, $filteredCount);
    }
}
