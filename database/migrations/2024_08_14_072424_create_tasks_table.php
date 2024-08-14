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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();

            $table->string('title');
            $table->string('description');
            $table->enum('status', ['selesai', 'proses', 'pending']);
            $table->date('due_date');

            $table->foreignUuid('project_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('user_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
