<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Directorio público de afiliados
        $businesses = Business::approved()
            ->active()
            ->with('user')
            ->latest()
            ->paginate(12);

        $businessTypes = Business::select('business_type')
            ->distinct()
            ->pluck('business_type');

        return view('welcome', compact('businesses', 'businessTypes'));
    }

    public function directory(Request $request)
    {
        $query = Business::approved()->active()->with('user');

        // Filtro por categoría/giro
        if ($request->filled('category')) {
            $query->where('business_type', $request->category);
        }

        // Filtro por búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%");
            });
        }

        // Filtro por ciudad
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $businesses = $query->paginate(12)->withQueryString();

        $businessTypes = Business::select('business_type')
            ->distinct()
            ->pluck('business_type');

        $cities = Business::approved()
            ->select('city')
            ->distinct()
            ->pluck('city');

        return view('directory', compact('businesses', 'businessTypes', 'cities'));
    }

    public function businessDetail($id)
    {
        $business = Business::approved()
            ->active()
            ->with('user')
            ->findOrFail($id);

        return view('business-detail', compact('business'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'collaborator':
                return redirect()->route('collaborator.dashboard');
            case 'business':
                return redirect()->route('business.dashboard');
            default:
                return redirect()->route('home');
        }
    }
}