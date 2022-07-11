<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication_datasets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publication_id')->references('id')->on('publications')->onDelete('cascade');
            $table->foreignId('dataset_id')->references('id')->on('datasets')->onDelete('cascade');
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
        Schema::dropIfExists('publication_datasets');
    }
};
