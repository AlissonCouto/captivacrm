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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // parameters = nicho, latitude e longitude
            $table->enum('searchType', ['text', 'parameters'])->default('text');
            $table->enum('messageType', ['chatgpt', 'replace'])->default('replace');
            $table->longText('messageDefault')->nullable();
            
            $table->unsignedBigInteger('companyId')->nullable();
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
