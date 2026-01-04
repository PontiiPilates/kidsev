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
            $table->foreignId('day_id')->default(null)->nullable()->constrained();
            $table->foreignId('program_id')->nullable()->constrained();
            $table->foreignId('event_id')->nullable()->constrained();
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('district_id')->constrained();
            $table->time('time_start');
            $table->time('time_end')->default(null)->nullable();
            $table->date('date')->nullable();
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
