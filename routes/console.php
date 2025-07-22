<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('crm:setup', function () {
    $this->info('Configurando CRM Cámara de Comercio...');
    
    // Ejecutar migraciones
    $this->call('migrate');
    
    // Ejecutar seeders
    $this->call('db:seed');
    
    // Crear enlaces simbólicos
    $this->call('storage:link');
    
    $this->info('¡CRM configurado exitosamente!');
})->purpose('Configurar el sistema CRM completo');