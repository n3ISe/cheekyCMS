<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageDimensionImageDimensionTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('imagedimension__imagedimension_translations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('imagedimension_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['imagedimension_id', 'locale']);
            $table->foreign('imagedimension_id')->references('id')->on('imagedimension__imagedimensions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('imagedimension__imagedimension_translations');
	}
}
