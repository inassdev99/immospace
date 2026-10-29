<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\VisitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VisitRequestController extends Controller
{
    public function create(Property $property)
    {
        abort_unless($property->status === 'Disponible', 404);

        return view('visit-form', [
            'property' => $property,
        ]);
    }

    public function store(Request $request, Property $property)
    {
        abort_unless($property->status === 'Disponible', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'min:6', 'max:30'],
            'preferred_date' => [
                'nullable',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        VisitRequest::create([
            ...$data,
            'property_id' => $property->id,
            'property_title' => $property->title,
            'status' => 'Nouveau',
        ]);

        return redirect()
            ->route('visits.create', $property)
            ->with(
                'success',
                'Votre demande a bien été enregistrée. La date souhaitée reste à confirmer par l’agence.'
            );
    }

    public function index()
    {
        $this->checkAdmin();

        return view('admin-visits', [
            'visits' => VisitRequest::with('property')
                ->latest('id')
                ->paginate(15),
            'newCount' => VisitRequest::where('status', 'Nouveau')->count(),
        ]);
    }

    public function update(Request $request, VisitRequest $visit)
    {
        $this->checkAdmin();

        $data = $request->validate([
            'status' => [
                'required',
                Rule::in(['Nouveau', 'En cours', 'Traité', 'Annulé']),
            ],
        ]);

        $visit->update($data);

        return redirect()
            ->route('admin.visits.index')
            ->with('success', 'Le statut de la demande a été mis à jour.');
    }

    private function checkAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);
    }
}