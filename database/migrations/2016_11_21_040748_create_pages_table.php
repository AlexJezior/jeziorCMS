<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreatePagesTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up(){
			Schema::create('plugin_pages', function(Blueprint $table){
				$table->increments('id');
				$table->string('title');
				$table->string('type', 75)->default('master');
				$table->integer('parent_id')->default(0);
				$table->string('permalink');
	               $table->mediumText('content');
				$table->string('meta_title');
				$table->mediumText('meta_keywords');
				$table->mediumText('meta_description');
				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down(){
			Schema::dropIfExists('plugin_pages');
		}
	}
