<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('event_type'); // feria, capacitacion, networking, etc.
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->text('location');
            $table->integer('max_participants')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};