<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYayasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yayasan', function (Blueprint $table) {
            $table->id();
            $table->integer('yayasan_id')->nullable();
            $table->integer('kategori_pr_id');
            $table->string('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('ttl')->nullable();
            $table->string('phone')->nullable();
            $table->string('foto')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('yayasan');
    }
}
