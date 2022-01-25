<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invoice::factory(50)->create()->each(function ($invoice) {
            InvoiceItem::factory(rand(1, 10))->create(['invoice_id' => $invoice->id]);
        });
    }
}
