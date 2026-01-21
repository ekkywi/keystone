<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('project_services', function (Blueprint $table) {
            $table->text('deployment_error')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('project_services', function (Blueprint $table) {
            $table->dropColumn('deployment_error');
        });
    }
};
