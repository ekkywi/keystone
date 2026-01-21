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
        Schema::table('project_services', function (Blueprint $table) {
            $table->string('repository_url')->nullable()->after('name');
            $table->string('branch')->default('main')->nullable()->after('repository_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_services', function (Blueprint $table) {
            $table->dropColumn(['repository_url', 'branch']);
        });
    }
};
