<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('collaborator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('business_name');
            $table->string('rfc')->unique();
            $table->string('business_type'); // giro comercial
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->enum('status', ['pending', 'approved', 'rejected', 'canceled'])->default('pending');
            $table->date('affiliation_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->json('benefits')->nullable(); // JSON para almacenar beneficios activos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};