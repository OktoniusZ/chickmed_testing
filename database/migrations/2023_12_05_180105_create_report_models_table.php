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
        Schema::create('report_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users");
            $table->string("date");
            $table->string("raw_image");
            $table->string("result_image");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_models');
    }
};
