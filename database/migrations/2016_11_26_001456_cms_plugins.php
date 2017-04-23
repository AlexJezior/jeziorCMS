<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsPlugins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('cms_plugins', function(Blueprint $table){
		    $table->increments('id');
		    $table->string('title');
		    $table->string('icon', 100)->default('star');
		    $table->string('cms_slug');
		    $table->string('cms_model', 55);
		    $table->string('cms_permalink');
		    $table->integer('display');
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
	    Schema::dropIfExists('cms_plugins');
    }
}
