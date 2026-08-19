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
        Schema::create('pricing_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tier')->default('silver'); // silver | gold | diamond | custom
            $table->string('icon');
            $table->string('price_prefix')->default('mulai dari'); // mulai dari | harga
            $table->string('price_amount'); // "800" atau "Fleksibel"
            $table->string('price_unit')->nullable(); // "rb", null untuk paket custom
            $table->json('features')->nullable();
            $table->string('cta_text');
            $table->string('cta_link')->default('#kontak');
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_packages');
    }
};
