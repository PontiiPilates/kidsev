<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_id')->constrained();
            $table->foreignId('program_id')->constrained();
            $table->foreignId('event_id')->constrained();
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->dateTime('time_from');
            $table->dateTime('time_to')->default(null);
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
        Schema::dropIfExists('timetables');
    }
}
