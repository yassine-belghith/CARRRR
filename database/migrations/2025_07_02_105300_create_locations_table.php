<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('postal_code');
            $table->string('phone');
            $table->string('email');
            $table->time('opening_hours_weekdays');
            $table->time('closing_hours_weekdays');
            $table->time('opening_hours_weekends')->nullable();
            $table->time('closing_hours_weekends')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
