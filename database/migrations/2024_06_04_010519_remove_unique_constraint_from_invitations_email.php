<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueConstraintFromInvitationsEmail extends Migration
{
    public function up()
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropUnique('invitations_email_unique');
        });
    }

    public function down()
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->unique('email');
        });
    }
}
