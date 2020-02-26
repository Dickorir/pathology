<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('index_no')->unique();
            $table->integer('math')->default(0);
            $table->string('math_grade')->nullable();
            $table->integer('eng')->default(0);
            $table->string('eng_grade')->nullable();
            $table->integer('kiswa')->default(0);
            $table->string('kiswa_grade')->nullable();
            $table->integer('sci')->default(0);
            $table->string('sci_grade')->nullable();
            $table->integer('soc_stud')->default(0);
            $table->string('soc_stud_grade')->nullable();
            $table->integer('tot_score')->default(0);
            $table->string('tot_grade')->nullable();
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
        Schema::dropIfExists('marks');
    }
}
