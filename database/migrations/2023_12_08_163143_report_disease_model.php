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
        Schema::create('report_disease_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId("report_model_id")->constrained("report_models");
            $table->foreignId("disease_model_id")->constrained("disease_models");
            $table->string("confidence");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
