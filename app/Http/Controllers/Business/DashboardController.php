<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Document;
use App\Models\Payment;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $business = $user->business;

        if (!$business) {
            return redirect()->route('business.profile.create')
                ->with('info', 'Completa tu perfil de negocio para acceder al panel.');
        }

        // Estadísticas del negocio
        $stats = [
            'status' => $business->status,
            'expiration_date' => $business->expiration_date,
            'days_until_expiration' => $business->getDaysUntilExpiration(),
            'total_payments' => $business->payments()->completed()->sum('amount'),
            'pending_payments' => $business->payments()->pending()->count(),
            'documents_pending' => $business->documents()->pending()->count(),
            'events_registered' => $business->eventRegistrations()->count(),
        ];

        // Documentos recientes
        $recentDocuments = $business->documents()
            ->latest()
            ->take(5)
            ->get();

        // Pagos recientes
        $recentPayments = $business->payments()
            ->latest()
            ->take(5)
            ->get();

        // Eventos próximos
        $upcomingEvents = EventRegistration::with('event')
            ->where('business_id', $business->id)
            ->whereHas('event', function($query) {
                $query->upcoming();
            })
            ->take(5)
            ->get();

        return view('business.dashboard', compact(
            'business',
            'stats',
            'recentDocuments',
            'recentPayments',
            'upcomingEvents'
        ));
    }

    public function profile()
    {
        $business = Auth::user()->business;
        return view('business.profile', compact('business'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email',
        ]);

        $business = Auth::user()->business;
        $business->update($request->all());

        return redirect()->route('business.profile')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function documents()
    {
        $business = Auth::user()->business;
        $documents = $business->documents()->latest()->paginate(10);
        
        return view('business.documents', compact('documents'));
    }

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $business = Auth::user()->business;
        $file = $request->file('document');
        
        $path = $file->store('documents/' . $business->id, 'local');
        
        Document::create([
            'business_id' => $business->id,
            'document_type' => $request->document_type,
            'document_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_at' => now(),
        ]);

        return redirect()->route('business.documents')
            ->with('success', 'Documento subido correctamente.');
    }

    public function payments()
    {
        $business = Auth::user()->business;
        $payments = $business->payments()->latest()->paginate(10);
        
        return view('business.payments', compact('payments'));
    }
}