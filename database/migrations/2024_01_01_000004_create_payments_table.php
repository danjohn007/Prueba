<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->string('payment_reference')->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['cash', 'transfer', 'card', 'paypal', 'stripe']);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->text('description');
            $table->date('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_path')->nullable();
            $table->json('payment_data')->nullable(); // Para datos adicionales del gateway
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};