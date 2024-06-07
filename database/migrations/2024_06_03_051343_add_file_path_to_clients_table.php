<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('status');
        });
    }
    
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
    
};