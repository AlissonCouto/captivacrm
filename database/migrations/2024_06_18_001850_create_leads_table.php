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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->text('website')->nullable();
            $table->datetime('lastContact')->nullable();
            $table->datetime('callScheduled')->nullable();
            $table->integer('status')->default(1);
            $table->integer('highlight')->default(0);
            $table->integer('order')->default(0);
            
            $table->unsignedBigInteger('companyId')->nullable();
            $table->unsignedBigInteger('statusId')->nullable();
            $table->unsignedBigInteger('nicheId')->nullable();
            $table->unsignedBigInteger('cityId')->nullable();

            $table->foreign('cityId')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('statusId')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('nicheId')->references('id')->on('niches')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
