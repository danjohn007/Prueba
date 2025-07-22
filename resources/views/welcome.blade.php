@extends('layouts.app')

@section('title', 'Bienvenido - CRM Cámara de Comercio')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold">Cámara de Comercio</h1>
                    <p class="lead">Únete a nuestra comunidad de comercios y aprovecha todos los beneficios de la afiliación.</p>
                    <div class="mt-4">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">Afiliate Ahora</a>
                        <a href="{{ route('directory') }}" class="btn btn-outline-light btn-lg">Ver Directorio</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400/0d6efd/ffffff?text=Cámara+de+Comercio" 
                         alt="Cámara de Comercio" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="display-5 fw-bold">Beneficios de Afiliación</h2>
                <p class="lead text-muted">Descubre todas las ventajas que ofrecemos a nuestros comercios afiliados</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-network-wired fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Networking</h5>
                        <p class="card-text">Conecta con otros comercios y amplía tu red de contactos empresariales.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Capacitaciones</h5>
                        <p class="card-text">Accede a cursos y talleres especializados para hacer crecer tu negocio.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-percentage fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Descuentos</h5>
                        <p class="card-text">Disfruta de descuentos exclusivos en servicios y productos para tu empresa.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Businesses -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="display-5 fw-bold">Comercios Destacados</h2>
                <p class="lead text-muted">Conoce algunos de nuestros comercios afiliados</p>
            </div>
        </div>
        
        <div class="row g-4">
            @forelse($businesses as $business)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $business->business_name }}</h5>
                            <p class="card-text">
                                <span class="badge bg-secondary">{{ $business->business_type }}</span>
                            </p>
                            <p class="card-text">{{ Str::limit($business->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $business->city }}, {{ $business->state }}
                                </small>
                                <a href="{{ route('business.detail', $business->id) }}" class="btn btn-primary btn-sm">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No hay comercios para mostrar en este momento.</p>
                </div>
            @endforelse
        </div>
        
        @if($businesses->hasPages())
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $businesses->links() }}
                </div>
            </div>
        @endif
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('directory') }}" class="btn btn-outline-primary btn-lg">
                    Ver Directorio Completo
                </a>
            </div>
        </div>
    </div>
</div>
@endsection