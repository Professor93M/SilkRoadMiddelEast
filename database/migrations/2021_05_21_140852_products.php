<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('pd_name');
            $table->bigInteger('pd_price');
            $table->integer('pd_stack');
            $table->boolean('pd_state')->default(0);
            $table->text('pd_description');
            $table->bigInteger('phone')->default('7733111109');
            $table->text('message')->default('اريد الاستفسار عن هذه السلعة');
            $table->text('review')->nullable();
            $table->text('cover');
            $table->bigInteger('categories_id')->unsigned();
            $table->bigInteger('sub_cats_id')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sub_cats_id')->references('id')->on('sub_cats')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('products');
    }
}
