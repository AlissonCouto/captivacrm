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
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100);
            $table->date('dueDate');
            $table->decimal('value', 9, 2);
            $table->date('competencyDate')->nullable();
            $table->string('formOfPayment', 100)->nullable();
            $table->boolean('received')->nullable();
            $table->decimal('amountReceived', 9, 2)->nullable();
            $table->date('deliveryDate')->nullable();
            $table->string('discounts', 100)->nullable();
            $table->string('interesAndFines', 100)->nullable();

            $table->unsignedBigInteger('companyId')->nullable();
            $table->unsignedBigInteger('costCenterId')->nullable();
            $table->unsignedBigInteger('bankAccountId')->nullable();
            $table->unsignedBigInteger('financialCategoryId')->nullable();
            $table->unsignedBigInteger('clientId')->nullable();

            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('costCenterId')->references('id')->on('cost_centers')->onDelete('cascade');
            $table->foreign('bankAccountId')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('financialCategoryId')->references('id')->on('financial_categories')->onDelete('cascade');
            $table->foreign('clientId')->references('id')->on('leads')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};
