<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('city');
            $table->string('district')->nullable();

            $table->enum('type', [
                'Villa',
                'Appartement',
                'Maison',
                'Terrain',
            ]);

            $table->enum('transaction', [
                'Vente',
                'Location',
            ]);

            $table->decimal('price', 14, 2);
            $table->unsignedInteger('area');
            $table->unsignedTinyInteger('bedrooms')->default(0);

            $table->string('image')->nullable();

            $table->enum('status', [
                'Disponible',
                'Vendu',
                'Loué',
            ])->default('Disponible');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};