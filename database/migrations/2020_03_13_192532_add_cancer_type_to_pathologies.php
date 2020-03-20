<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancerTypeToPathologies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pathologies', function (Blueprint $table) {
            $table->string('cancer_type')->nullable()->after('clinical_history_notes');
            $table->string('cancer_stage')->nullable()->after('cancer_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pathologies', function (Blueprint $table) {
            //
        });
    }
}
