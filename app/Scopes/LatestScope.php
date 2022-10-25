<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LatestScope implements Scope
{

    //modifies all queries of Models which use the GlobalScope
    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy($model::CREATED_AT, 'desc');
    }
}
