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
        //
        Schema::create('project_task_progress', function (Blueprint $table) {
            $table->id();
            $table->char('task_sequence_no_wbs', 30);
            $table->integer('project_id');
            $table->index(['task_sequence_no_wbs', 'project_id']);
            $table->string('task_name', 200);
            $table->date('task_actual_start_date')->nullable();
            $table->date('task_actual_end_date')->nullable();
            $table->integer('task_progress_percentage');
            $table->string('last_update_bywhom',150)->nullable();
            $table->foreignId('user_login_name')->nullable();
            $table->foreign('user_login_name')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::create('project_task_progress_logs', function (Blueprint $table) {
            $table->id();
            $table->char('task_sequence_no_wbs', 30);
            $table->foreignId('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->index(['task_sequence_no_wbs', 'project_id']);
            $table->string('task_name', 200);
            $table->date('task_actual_start_date')->nullable();
            $table->date('task_actual_end_date')->nullable();
            $table->integer('task_progress_percentage');
            $table->string('last_update_bywhom',150)->nullable();
            $table->foreignId('user_login_name')->nullable();
            $table->foreign('user_login_name')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('project_task_progress');
        Schema::dropIfExists('project_task_progress_log');
    }
};
