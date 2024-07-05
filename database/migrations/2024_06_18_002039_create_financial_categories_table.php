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
        Schema::create('financial_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug');
            $table->integer('type')->nullable();
            $table->unsignedBigInteger('parentId')->nullable();
            $table->unsignedBigInteger('companyId')->nullable();
            
            $table->foreign('parentId')->references('id')->on('financial_categories')->onDelete('cascade');
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_categories');
    }
};
