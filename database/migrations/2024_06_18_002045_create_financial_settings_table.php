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
        Schema::create('financial_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('cashFlowType', ['simple', 'complete'])->default('complete');
            $table->unsignedBigInteger('costCenterId')->nullable();
            $table->unsignedBigInteger('bankAccountId')->nullable();
            $table->unsignedBigInteger('financialCategoryId')->nullable();
            $table->unsignedBigInteger('companyId')->nullable();

            $table->foreign('costCenterId')->references('id')->on('cost_centers')->onDelete('cascade');
            $table->foreign('bankAccountId')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('financialCategoryId')->references('id')->on('financial_categories')->onDelete('cascade');
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_settings');
    }
};
