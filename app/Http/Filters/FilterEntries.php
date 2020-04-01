<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class FilterEntries extends Filter
{

    /**
     * Filter the products by the given year.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function from(string $value = null): Builder
    {
        $value = new Carbon($value);
        if(isset($value)) return $this->builder->whereDate('created_at', '>=', $value);
        return $this->builder->where('created_at', '!=', null);
    }

    public function to(string $value = null): Builder
    {
        $value = new Carbon($value);
        if(isset($value)) return $this->builder->whereDate('created_at', '<=', $value);
        return $this->builder->where('created_at', '!=', null);
    }

    public function batch(string $value = null): Builder
    {
        if(isset($value)) return $this->builder->where('batch_id', $value);
        return $this->builder->where('created_at', '!=', null);
    }

    public function denomination(string $value = null): Builder
    {
        if(isset($value)) return $this->builder->where('denomination_id', $value);
        return $this->builder->where('created_at', '!=', null);
    }
}
