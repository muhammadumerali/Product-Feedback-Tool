<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_9173657')->references('id')->on('users');
            $table->unsignedBigInteger('feedback_id')->nullable();
            $table->foreign('feedback_id', 'feedback_fk_9173658')->references('id')->on('feedbacks');
        });
    }
}
