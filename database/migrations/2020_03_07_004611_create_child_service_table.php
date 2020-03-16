<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_service', function (Blueprint $table) {
            $table->id();

            $table->string('diagnosis_area');
            $table->integer('diagnosis_count');

            $table->timestamp('first_appearance');
            $table->timestamp('end_of_charge')->nullable();
            $table->string('end_reason')->nullable();

            $table->timestamp('from');
            $table->timestamp('to')->nullable();
            $table->integer('attendance_months');

            $table->string('source');

            $table->string('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->string('child_id');
            $table->foreign('child_id')->references('id')->on('children');

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
        Schema::dropIfExists('child_service');
    }
}
