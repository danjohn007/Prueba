<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Models\Payment;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_businesses' => Business::count(),
            'approved_businesses' => Business::approved()->count(),
            'pending_businesses' => Business::pending()->count(),
            'total_collaborators' => User::collaborators()->count(),
            'total_payments' => Payment::completed()->sum('amount'),
            'pending_payments' => Payment::pending()->sum('amount'),
            'total_commissions' => Commission::sum('commission_amount'),
            'pending_commissions' => Commission::pending()->sum('commission_amount'),
        ];

        // Gráficas de desempeño por colaborador
        $collaboratorStats = User::collaborators()
            ->withCount(['collaboratedBusinesses as total_affiliations'])
            ->withSum(['commissions as total_commissions' => function($query) {
                $query->where('status', 'paid');
            }], 'commission_amount')
            ->get();

        // Estadísticas por región
        $regionStats = Business::select('state', DB::raw('count(*) as total'))
            ->groupBy('state')
            ->get();

        // Estadísticas por giro comercial
        $businessTypeStats = Business::select('business_type', DB::raw('count(*) as total'))
            ->groupBy('business_type')
            ->get();

        // Afiliaciones recientes
        $recentAffiliations = Business::with(['user', 'collaborator'])
            ->latest()
            ->take(10)
            ->get();

        // Pagos pendientes
        $pendingPayments = Payment::with('business')
            ->pending()
            ->orderBy('due_date')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'collaboratorStats',
            'regionStats',
            'businessTypeStats',
            'recentAffiliations',
            'pendingPayments'
        ));
    }

    public function exportReport(Request $request)
    {
        // Lógica para exportar reportes en PDF/Excel
        // Se implementará con las librerías correspondientes
        return response()->json(['message' => 'Funcionalidad de exportación en desarrollo']);
    }
}