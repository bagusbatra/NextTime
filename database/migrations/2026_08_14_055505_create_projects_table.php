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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('tag');
            $table->string('category'); // umkm | company-profile | landing-page
            $table->string('status')->default('soon'); // available | soon
            $table->string('mockup_type')->nullable(); // resto | shop | company
            $table->string('icon')->nullable(); // ikon lucide untuk kartu "segera hadir"
            $table->text('summary');
            $table->text('overview')->nullable();
            $table->json('features')->nullable();
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
