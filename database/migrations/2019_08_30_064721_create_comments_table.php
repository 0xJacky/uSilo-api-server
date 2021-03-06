<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();

            $table->longText('content');

            $table->uuid('post_id')->nullable();
            $table->foreign('post_id')->references('id')
                ->on('posts')->onDelete('cascade')
                ->onUpdate('cascade');

            $table->uuid('parent')->nullable();

            $table->uuid('upload_id')->nullable();
            $table->foreign('upload_id')->references('id')
                ->on('uploads')->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
