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
        Schema::create('stack_variables', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('stack_id')->constrained('stacks')->onDelete('cascade');
            $table->string('env_key');
            $table->string('label');
            $table->string('type')->default('text');
            $table->string('default_value')->nullable();
            $table->boolean('is_required')->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stack_variables');
    }
};
