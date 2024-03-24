<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('sales_commission_view');

        Schema::create('sales_commission_view', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->string('company');
            $table->string('seller');
            $table->string('client');
            $table->string('city');
            $table->string('state');
            $table->dateTime('sold_at');
            $table->string('status');
            $table->decimal('total_amount');
            $table->decimal('commission');
            $table->timestamps();
        });

        // Popule a tabela com os resultados da consulta
        $query = DB::table('sales as s')
            ->join('sellers as sl', 'sl.id', '=' ,'s.seller_id')
            ->join('clients as cl', 'cl.id','=','s.client_id')
            ->join('companies as cp', 'cp.id','=','sl.company_id')
            ->join('addresses as ad', 'ad.id', '=', 'cl.address_id')
            ->join('users as us', 'us.id', '=', 'sl.user_id')
            ->join('users as uc', 'uc.id', '=', 'cl.user_id')
            ->selectRaw("
                sl.company_id,
                cp.name as company,
                us.name as seller,
                uc.name as client,
                ad.city,
                ad.state,
                s.sold_at,
                s.status,
                s.total_amount,
                round(s.total_amount * cp.commission_rate / 100) as commission
            ");
        
        DB::table('sales_commission_view')->insertUsing(
            ['company_id', 'company', 'seller', 'client', 'city', 'state', 'sold_at', 'status', 'total_amount', 'commission'],
            $query
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_commission_view');
    }
};
