@extends('layouts.app')

@section('title', $business->business_name)

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('directory') }}">Directorio</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $business->business_name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="h3 text-primary mb-2">{{ $business->business_name }}</h1>
                            <span class="badge bg-secondary fs-6">{{ $business->business_type }}</span>
                        </div>
                        <div class="text-end">
                            @if($business->website)
                                <a href="{{ $business->website }}" target="_blank" class="btn btn-outline-primary mb-2">
                                    <i class="fas fa-globe"></i>
                                    Sitio Web
                                </a>
                                <br>
                            @endif
                            <small class="text-muted">
                                Afiliado desde {{ $business->affiliation_date ? $business->affiliation_date->format('F Y') : 'N/A' }}
                            </small>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($business->description)
                        <div class="mb-4">
                            <h5>Acerca de nosotros</h5>
                            <p class="text-muted">{{ $business->description }}</p>
                        </div>
                    @endif

                    <!-- Benefits -->
                    @if($business->benefits && is_array($business->benefits))
                        <div class="mb-4">
                            <h5>Beneficios y Servicios</h5>
                            <div class="row g-3">
                                @foreach($business->benefits as $benefit => $active)
                                    @if($active)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <span>{{ ucwords(str_replace('_', ' ', $benefit)) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Information -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Información Adicional</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>RFC:</strong> {{ $business->rfc }}</p>
                            <p><strong>Giro Comercial:</strong> {{ $business->business_type }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Ciudad:</strong> {{ $business->city }}</p>
                            <p><strong>Estado:</strong> {{ $business->state }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Contact Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-address-book"></i>
                        Información de Contacto
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Dirección</h6>
                        <p class="mb-0">{{ $business->address }}</p>
                        <small class="text-muted">{{ $business->city }}, {{ $business->state }} {{ $business->postal_code }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Teléfono</h6>
                        <p class="mb-0">
                            <a href="tel:{{ $business->contact_phone }}" class="text-decoration-none">
                                {{ $business->contact_phone }}
                            </a>
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Email</h6>
                        <p class="mb-0">
                            <a href="mailto:{{ $business->contact_email }}" class="text-decoration-none">
                                {{ $business->contact_email }}
                            </a>
                        </p>
                    </div>

                    @if($business->website)
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Sitio Web</h6>
                            <p class="mb-0">
                                <a href="{{ $business->website }}" target="_blank" class="text-decoration-none">
                                    {{ parse_url($business->website, PHP_URL_HOST) }}
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt"></i>
                        Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="tel:{{ $business->contact_phone }}" class="btn btn-success">
                            <i class="fas fa-phone"></i>
                            Llamar
                        </a>
                        <a href="mailto:{{ $business->contact_email }}" class="btn btn-primary">
                            <i class="fas fa-envelope"></i>
                            Enviar Email
                        </a>
                        @if($business->website)
                            <a href="{{ $business->website }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-globe"></i>
                                Visitar Sitio Web
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Share -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-share-alt"></i>
                        Compartir
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Comparte este negocio con tus contactos</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary btn-sm" onclick="shareUrl()">
                            <i class="fas fa-copy"></i>
                            Copiar Enlace
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Businesses -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-4">Otros comercios que te pueden interesar</h4>
            <div class="row g-4">
                <!-- This would show related businesses - simplified for demo -->
                <div class="col-12 text-center text-muted">
                    <p>Funcionalidad de comercios relacionados en desarrollo</p>
                    <a href="{{ route('directory') }}" class="btn btn-outline-primary">
                        Ver Más Comercios
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function shareUrl() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $business->business_name }}',
            text: '{{ $business->description }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Enlace copiado al portapapeles');
        });
    }
}
</script>
@endpush
@endsection