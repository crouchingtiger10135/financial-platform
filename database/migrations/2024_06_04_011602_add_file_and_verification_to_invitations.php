<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileAndVerificationToInvitations extends Migration
{
    public function up()
    {
        Schema::table('invitations', function (Blueprint $table) {
            if (!Schema::hasColumn('invitations', 'file_path')) {
                $table->string('file_path')->nullable();
            }
            if (!Schema::hasColumn('invitations', 'verification_status')) {
                $table->boolean('verification_status')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('invitations', function (Blueprint $table) {
            if (Schema::hasColumn('invitations', 'file_path')) {
                $table->dropColumn('file_path');
            }
            if (Schema::hasColumn('invitations', 'verification_status')) {
                $table->dropColumn('verification_status');
            }
        });
    }
}
