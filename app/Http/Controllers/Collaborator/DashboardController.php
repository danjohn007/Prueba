<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Estadísticas del colaborador
        $stats = [
            'total_affiliations' => $user->collaboratedBusinesses()->count(),
            'approved_affiliations' => $user->collaboratedBusinesses()->approved()->count(),
            'pending_affiliations' => $user->collaboratedBusinesses()->pending()->count(),
            'total_commissions' => $user->commissions()->sum('commission_amount'),
            'paid_commissions' => $user->commissions()->paid()->sum('commission_amount'),
            'pending_commissions' => $user->commissions()->pending()->sum('commission_amount'),
        ];

        // Afiliaciones recientes
        $recentAffiliations = $user->collaboratedBusinesses()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Comisiones recientes
        $recentCommissions = $user->commissions()
            ->with('business')
            ->latest()
            ->take(10)
            ->get();

        // Estadísticas mensuales
        $monthlyStats = $this->getMonthlyStats($user->id);

        // Ranking interno (posición entre colaboradores)
        $ranking = $this->getCollaboratorRanking($user->id);

        return view('collaborator.dashboard', compact(
            'stats',
            'recentAffiliations',
            'recentCommissions',
            'monthlyStats',
            'ranking'
        ));
    }

    public function affiliations()
    {
        $user = Auth::user();
        $affiliations = $user->collaboratedBusinesses()
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('collaborator.affiliations', compact('affiliations'));
    }

    public function commissions()
    {
        $user = Auth::user();
        $commissions = $user->commissions()
            ->with('business')
            ->latest()
            ->paginate(15);

        return view('collaborator.commissions', compact('commissions'));
    }

    public function monthlyReport(Request $request)
    {
        $user = Auth::user();
        $month = $request->get('month', now()->format('Y-m'));
        
        $monthlyData = [
            'month' => $month,
            'affiliations' => $user->collaboratedBusinesses()
                ->whereMonth('affiliation_date', '=', date('m', strtotime($month)))
                ->whereYear('affiliation_date', '=', date('Y', strtotime($month)))
                ->count(),
            'commissions' => $user->commissions()
                ->whereMonth('earned_date', '=', date('m', strtotime($month)))
                ->whereYear('earned_date', '=', date('Y', strtotime($month)))
                ->sum('commission_amount'),
            'ranking' => $this->getMonthlyRanking($user->id, $month),
        ];

        return view('collaborator.monthly-report', compact('monthlyData'));
    }

    private function getMonthlyStats($collaboratorId)
    {
        return DB::table('businesses')
            ->select(
                DB::raw('YEAR(affiliation_date) as year'),
                DB::raw('MONTH(affiliation_date) as month'),
                DB::raw('COUNT(*) as affiliations'),
                DB::raw('SUM(commission_rate) as total_commissions')
            )
            ->where('collaborator_id', $collaboratorId)
            ->whereNotNull('affiliation_date')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();
    }

    private function getCollaboratorRanking($collaboratorId)
    {
        $rankings = DB::table('users')
            ->select('users.id', 'users.name', DB::raw('COUNT(businesses.id) as total_affiliations'))
            ->leftJoin('businesses', 'users.id', '=', 'businesses.collaborator_id')
            ->where('users.role', 'collaborator')
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_affiliations', 'desc')
            ->get();

        $position = $rankings->search(function ($item) use ($collaboratorId) {
            return $item->id == $collaboratorId;
        });

        return [
            'position' => $position !== false ? $position + 1 : null,
            'total_collaborators' => $rankings->count(),
            'top_collaborators' => $rankings->take(5),
        ];
    }

    private function getMonthlyRanking($collaboratorId, $month)
    {
        $rankings = DB::table('users')
            ->select('users.id', 'users.name', DB::raw('COUNT(businesses.id) as monthly_affiliations'))
            ->leftJoin('businesses', function($join) use ($month) {
                $join->on('users.id', '=', 'businesses.collaborator_id')
                     ->whereMonth('businesses.affiliation_date', '=', date('m', strtotime($month)))
                     ->whereYear('businesses.affiliation_date', '=', date('Y', strtotime($month)));
            })
            ->where('users.role', 'collaborator')
            ->groupBy('users.id', 'users.name')
            ->orderBy('monthly_affiliations', 'desc')
            ->get();

        $position = $rankings->search(function ($item) use ($collaboratorId) {
            return $item->id == $collaboratorId;
        });

        return $position !== false ? $position + 1 : null;
    }
}