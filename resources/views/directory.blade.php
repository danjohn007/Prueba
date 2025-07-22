@extends('layouts.app')

@section('title', 'Directorio de Comercios')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold text-center mb-3">Directorio de Comercios Afiliados</h1>
            <p class="lead text-muted text-center">Descubre todos nuestros comercios afiliados y sus servicios</p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('directory') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Buscar</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Nombre, descripción...">
                            </div>
                            <div class="col-md-3">
                                <label for="category" class="form-label">Categoría</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Todas las categorías</option>
                                    @foreach($businessTypes as $type)
                                        <option value="{{ $type }}" {{ request('category') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="city" class="form-label">Ciudad</label>
                                <select class="form-select" id="city" name="city">
                                    <option value="">Todas las ciudades</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i>
                                    Buscar
                                </button>
                            </div>
                        </div>
                        @if(request()->hasAny(['search', 'category', 'city']))
                            <div class="row mt-3">
                                <div class="col-12">
                                    <a href="{{ route('directory') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times"></i>
                                        Limpiar Filtros
                                    </a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    {{ $businesses->total() }} comercio{{ $businesses->total() != 1 ? 's' : '' }} encontrado{{ $businesses->total() != 1 ? 's' : '' }}
                </h5>
                @if(request()->hasAny(['search', 'category', 'city']))
                    <span class="badge bg-info">Filtros aplicados</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Businesses Grid -->
    <div class="row g-4">
        @forelse($businesses as $business)
            <div class="col-lg-4 col-md-6">
                <div class="card business-card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title text-primary">{{ $business->business_name }}</h5>
                            <span class="badge bg-secondary">{{ $business->business_type }}</span>
                        </div>
                        
                        <p class="card-text text-muted">
                            {{ Str::limit($business->description, 120) }}
                        </p>
                        
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $business->city }}, {{ $business->state }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-phone"></i>
                                {{ $business->contact_phone }}
                            </small>
                            @if($business->website)
                                <br>
                                <small>
                                    <a href="{{ $business->website }}" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-globe"></i>
                                        Sitio Web
                                    </a>
                                </small>
                            @endif
                        </div>
                        
                        <!-- Benefits -->
                        @if($business->benefits && is_array($business->benefits))
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Beneficios:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($business->benefits as $benefit => $active)
                                        @if($active)
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                {{ ucwords(str_replace('_', ' ', $benefit)) }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Afiliado desde {{ $business->affiliation_date ? $business->affiliation_date->format('M Y') : 'N/A' }}
                            </small>
                            <a href="{{ route('business.detail', $business->id) }}" class="btn btn-primary btn-sm">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No se encontraron comercios</h5>
                    <p class="text-muted">Intenta ajustar tus filtros de búsqueda</p>
                    <a href="{{ route('directory') }}" class="btn btn-outline-primary">
                        Ver Todos los Comercios
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($businesses->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $businesses->withQueryString()->links() }}
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.business-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 15px;
}

.business-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.badge {
    font-size: 0.75rem;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
}
</style>
@endpush
@endsection