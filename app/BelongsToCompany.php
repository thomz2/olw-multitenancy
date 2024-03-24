<?php

namespace App;
use App\Models\Scopes\CompanyScope;

// BelongsTo<Tenant>
trait BelongsToCompany
{
    protected static function bootBelongsToCompany() 
    {
        // Aplicando escopo para uma query builder que tenha relacao com esse model
        static::addGlobalScope(new CompanyScope);

        // Mesmo que seja forçada a criação de um model com uma company id que nao seja a verdadeira, eu impeco que isso aconteca
        static::creating(function ($model) {
            if (session()->has('company_id')) {
                $model->company_id = session()->get('company_id');
            }
        });

        // Mesmo que seja forçada a atualizacao de um model com uma company id que nao seja a verdadeira, eu impeco que isso aconteca
        static::updating(function ($model) {
            if (session()->has('company_id')) {
                $model->company_id = session()->get('company_id');
            }
        });
    }
}
