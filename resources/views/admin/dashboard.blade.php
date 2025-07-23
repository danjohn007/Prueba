@extends('layouts.app')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Dashboard Administrador</h1>
                <div>
                    <button class="btn btn-outline-primary" onclick="exportReport()">
                        <i class="fas fa-download"></i>
                        Exportar Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Comercios
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_businesses']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Comercios Aprobados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['approved_businesses']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pagos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($stats['total_payments'], 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Colaboradores
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_collaborators']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficas y Tablas -->
    <div class="row">
        <!-- Gráfica de Colaboradores -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rendimiento por Colaborador</h6>
                </div>
                <div class="card-body">
                    <canvas id="collaboratorChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Estadísticas por Región -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribución por Estado</h6>
                </div>
                <div class="card-body">
                    <canvas id="regionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablas de Datos -->
    <div class="row">
        <!-- Afiliaciones Recientes -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Afiliaciones Recientes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Comercio</th>
                                    <th>Colaborador</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAffiliations as $business)
                                    <tr>
                                        <td>{{ $business->business_name }}</td>
                                        <td>{{ $business->collaborator->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $business->status == 'approved' ? 'success' : ($business->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($business->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $business->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay afiliaciones recientes</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagos Pendientes -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pagos Pendientes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Comercio</th>
                                    <th>Monto</th>
                                    <th>Vencimiento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->business->business_name }}</td>
                                        <td>${{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->due_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->isOverdue() ? 'danger' : 'warning' }}">
                                                {{ $payment->isOverdue() ? 'Vencido' : 'Pendiente' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay pagos pendientes</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Gráfica de Colaboradores
const collaboratorData = @json($collaboratorStats);
const collaboratorCtx = document.getElementById('collaboratorChart').getContext('2d');
new Chart(collaboratorCtx, {
    type: 'bar',
    data: {
        labels: collaboratorData.map(c => c.name),
        datasets: [{
            label: 'Afiliaciones',
            data: collaboratorData.map(c => c.total_affiliations),
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfica de Regiones
const regionData = @json($regionStats);
const regionCtx = document.getElementById('regionChart').getContext('2d');
new Chart(regionCtx, {
    type: 'doughnut',
    data: {
        labels: regionData.map(r => r.state),
        datasets: [{
            data: regionData.map(r => r.total),
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

function exportReport() {
    // Funcionalidad de exportación
    alert('Funcionalidad de exportación en desarrollo');
}
</script>
@endpush

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
</style>
@endpush
@endsection