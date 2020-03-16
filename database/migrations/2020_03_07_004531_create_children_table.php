<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->enum('gender', ['M', 'F']);
            $table->timestamp('birth_date');

            $table->string('born_city')->nullable();
            $table->string('born_state')->nullable();
            $table->string('nationality')->nullable();

            $table->string('home_city')->nullable();
            $table->string('home_district')->nullable();
            $table->string('home_cap')->nullable();
            $table->string('home_municipality')->nullable();
            $table->string('home_metropolitan_area')->nullable();

            $table->string('family_id');
            $table->foreign('family_id')->references('id')->on('families');

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
        Schema::dropIfExists('children');
    }
}
