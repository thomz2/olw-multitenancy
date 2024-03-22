<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AddressSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            SaleSeeder::class
        ]);

        // Truncate a tabela
        DB::statement("TRUNCATE TABLE sales_commission_view");

        // Reinsira os dados atualizados
        DB::statement("
            INSERT INTO sales_commission_view (company, seller, client, city, state, sold_at, status, total_amount, commission)
            SELECT
                cp.name as company,
                us.name as seller,
                uc.name as client,
                ad.city,
                ad.state,
                s.sold_at,
                s.status,
                s.total_amount,
                ROUND(s.total_amount * cp.commission_rate / 100) as commission
            FROM sales as s
            INNER JOIN sellers as sl ON sl.id = s.seller_id
            INNER JOIN clients as cl ON cl.id = s.client_id
            INNER JOIN companies as cp ON cp.id = sl.company_id
            INNER JOIN addresses as ad ON ad.id = cl.address_id
            INNER JOIN users as us ON us.id = sl.user_id
            INNER JOIN users as uc ON uc.id = cl.user_id
        ");
    }
}
