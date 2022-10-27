<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DeletedAdminScope implements Scope
{
    //modifies all queries of Models which use the GlobalScope
    public function apply(Builder $builder, Model $model)
    {
        if(Auth::check() && Auth::user()->is_admin){
            //$builder->withTrashed();
            $builder->withoutGlobalScope(SoftDeletingScope::class);
        }
    }
}
