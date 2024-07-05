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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('sid')->nullable();
            $table->string('status')->nullable();
            $table->longtext('message')->nullable();
            $table->string('phone')->nullable();
            $table->string('from')->nullable();

            $table->unsignedBigInteger('leadId');
            $table->unsignedBigInteger('companyId');

            $table->foreign('leadId')->references('id')->on('leads');
            $table->foreign('companyId')->references('id')->on('companies');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
