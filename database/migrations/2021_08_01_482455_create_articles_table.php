<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('size');
            $table->string('path');
            $table->integer('views')->default(0);
            $table->string('pages');
            $table->string('chapter');
            $table->text('about_author')->nullable();
            $table->text('about_article')->nullable();
            $table->string('approved');
            $table->date('publish_date');
            $table->string('language');
            $table->integer('downloads')->default(0);
            $table->text('tags');
            $table->string('rate')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
