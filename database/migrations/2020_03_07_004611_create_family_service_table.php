<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_service', function (Blueprint $table) {
            $table->id();

            $table->datetime('end_of_charge')->nullable();

            $table->datetime('first_appearance');
            $table->datetime('from');
            $table->datetime('to')->nullable();
            $table->integer('attendance_months');

            $table->string('relationship_degree')->nullable();
            $table->string('activity_1')->nullable();
            $table->string('activity_2')->nullable();
            $table->string('activity_3')->nullable();
            $table->string('activity_4')->nullable();

            $table->string('service_id');
            $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete();
            $table->string('family_id');
            $table->foreign('family_id')->references('id')->on('families')->cascadeOnDelete();

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
        Schema::dropIfExists('family_service');
    }
}
