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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('slogan')->nullable();
            $table->string('logo')->nullable();
            $table->string('cnpj', 18)->nullable();
            $table->string('niche')->nullable();
            $table->string('timezone')->nullable();

            $table->unsignedBigInteger('userId')->nullable();

            $table->foreign('userId')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
