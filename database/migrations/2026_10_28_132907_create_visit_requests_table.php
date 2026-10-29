<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->nullable()
                ->constrained('properties')
                ->nullOnDelete();

            $table->string('property_title');
            $table->string('name', 150);
            $table->string('email');
            $table->string('phone', 30);
            $table->date('preferred_date')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('Nouveau');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_requests');
    }
};