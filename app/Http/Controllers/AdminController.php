<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    private function checkAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);
    }

    public function loginForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin', [
            'showLogin' => true,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials['is_admin'] = true;

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'Email ou mot de passe incorrect.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        $this->checkAdmin();

        return view('admin', [
            'showLogin' => false,
            'total' => Property::count(),
            'available' => Property::where('status', 'Disponible')->count(),
            'sales' => Property::where('status', 'Disponible')
                ->where('transaction', 'Vente')
                ->count(),
            'rentals' => Property::where('status', 'Disponible')
                ->where('transaction', 'Location')
                ->count(),
            'properties' => Property::latest('id')->paginate(10),
        ]);
    }

    public function create()
    {
        $this->checkAdmin();

        return view('admin-property-form', [
            'property' => new Property(),
        ]);
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $data = $this->validateProperty($request);

        unset($data['photo']);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('properties', 'public');
            $data['image'] = '/storage/'.$path;
        }

        Property::create($data);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Le bien a été ajouté avec succès.');
    }

    public function edit(Property $property)
    {
        $this->checkAdmin();

        return view('admin-property-form', [
            'property' => $property,
        ]);
    }

    public function update(Request $request, Property $property)
    {
        $this->checkAdmin();

        $data = $this->validateProperty($request);

        unset($data['photo']);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('properties', 'public');
            $data['image'] = '/storage/'.$path;
        }

        $property->update($data);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Le bien a été modifié avec succès.');
    }

    public function destroy(Property $property)
    {
        $this->checkAdmin();

        $property->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Le bien a été supprimé.');
    }

    private function validateProperty(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:150'],
            'type' => [
                'required',
                Rule::in(['Villa', 'Appartement', 'Maison', 'Terrain']),
            ],
            'transaction' => [
                'required',
                Rule::in(['Vente', 'Location']),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999999.99',
            ],
            'area' => [
                'required',
                'integer',
                'min:1',
                'max:4294967295',
            ],
            'bedrooms' => [
                'required',
                'integer',
                'min:0',
                'max:255',
            ],
            'status' => [
                'required',
                Rule::in(['Disponible', 'Vendu', 'Loué']),
            ],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}