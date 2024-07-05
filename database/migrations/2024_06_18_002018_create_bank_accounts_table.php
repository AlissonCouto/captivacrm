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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('cardholderName', 255)->nullable();
            $table->string('slug');
            $table->string('cpfCnpj', 25)->nullable()->unique();
            $table->string('bankAccountName', 100);
            $table->string('agency', 100);
            $table->enum('type', ['chain', 'savings', 'wage', 'others']);
            $table->string('accountNumber', 100);
            $table->boolean('default')->default(0);
            $table->unsignedBigInteger('companyId')->nullable();
            $table->unsignedBigInteger('bankId')->nullable();
            
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('bankId')->references('id')->on('banks')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
