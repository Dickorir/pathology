<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pathologies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_id');
            $table->string('hospital')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('request_form_name')->nullable();
            $table->string('request_form_upload')->nullable();
            $table->string('form_number')->nullable();
            $table->date('date')->nullable();
            $table->string('type_of_test')->nullable();
            $table->string('specimen')->nullable();
            $table->longText('report')->nullable();
            $table->string('report_upload')->nullable();
            $table->longText('clinical_history_notes')->nullable();
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
        Schema::dropIfExists('pathologies');
    }
}
