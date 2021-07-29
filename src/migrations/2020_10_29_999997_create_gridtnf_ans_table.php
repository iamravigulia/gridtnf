<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGridtnfAnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fmt_gridtnf_ans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id');
            $table->enum('answer', ['true', 'false'])->nullable();
            $table->enum('arrange', [0, 1])->default(0);
            $table->enum('active', [0, 1])->default(1);
            $table->string('eng_word')->nullable();
            // $table->foreignId('media_id')->nullable();
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
        Schema::dropIfExists('fmt_gridtnf_ans');
    }
}
