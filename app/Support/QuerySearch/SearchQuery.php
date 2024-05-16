<?php

namespace App\Support\QuerySearch;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

final class SearchQuery implements SearchQueryInterface
{
    protected Request $request;

    protected Builder $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder, string $table): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value, $table]));
            }
        }

        return $this->builder;
    }

    public function sort(array $value, string $table): Builder
    {
        $sorts = array_unique($value);

        foreach ($sorts as $column) {
            $colInTable = ltrim($column, '-+');
            if ($column[0] === '-' && Schema::hasColumn($table, $colInTable)) {
                $this->builder->orderByDesc($colInTable);
            } else if (Schema::hasColumn($table, $colInTable)) {
                $this->builder->orderBy($colInTable);
            }
        }

        return $this->builder;
    }

    public function filter(array $value, string $table): Builder
    {
        $filters = array_unique($value);

        foreach ($filters as $column => $val) {
            [$isLikeSearch, $colInTable] = $this->isLikeSearchColumn($column);
            if ($isLikeSearch && Schema::hasColumn($table, $colInTable)) {
                $this->builder->where($colInTable, 'like', "%$val%");
            } else if (Schema::hasColumn($table, $colInTable)) {
                if (is_array($val)) {
                    $this->builder->whereIn($colInTable, $val);
                } else {
                    $this->builder->where($colInTable, $val);
                }
            }
        }

        return $this->builder;
    }

    public function include($value): Builder
    {
        $this->builder->with(explode(',', $value));

        return $this->builder;
    }
}
