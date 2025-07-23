<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collaborator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->decimal('commission_amount', 10, 2);
            $table->decimal('commission_percentage', 5, 2);
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending');
            $table->date('earned_date');
            $table->date('paid_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commissions');
    }
};