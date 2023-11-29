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
        Schema::create('user_accessibles', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->unsignedBigInteger('project_id');

            // $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            // $table->unique(['project_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_accessibles');
    }
};
