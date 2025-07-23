<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['registered', 'confirmed', 'attended', 'canceled'])->default('registered');
            $table->timestamp('registered_at');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['event_id', 'business_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_registrations');
    }
};