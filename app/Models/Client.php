<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
// use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

// #[ScopedBy([CompanyScope::class])]
class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id',
        'user_id'
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted() 
    {
        // Aplicando escopo para uma query builder que tenha relacao com esse model
        static::addGlobalScope(new CompanyScope);

        // Mesmo que seja forçada a criação de um model com uma company id que nao seja a verdadeira, eu impeco que isso aconteca
        static::creating(function ($client) {
            if (session()->has('company_id')) {
                $client->company_id = session()->get('company_id');
            }
        });

        // Mesmo que seja forçada a atualizacao de um model com uma company id que nao seja a verdadeira, eu impeco que isso aconteca
        static::updating(function ($client) {
            if (session()->has('company_id')) {
                $client->company_id = session()->get('company_id');
            }
        });
    }
}
