<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVotesTable extends Migration
{
    public function up()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->unsignedBigInteger('feedback_id')->nullable();
            $table->foreign('feedback_id', 'feedback_fk_9173665')->references('id')->on('feedbacks');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_9173666')->references('id')->on('users');
        });
    }
}
