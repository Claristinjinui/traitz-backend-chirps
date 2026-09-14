<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
     use AuthorizesRequests;

    public function index(Request $request)
    {
        // Exercise 6: Search + Pagination
        $search = $request->input('search');

        $chirps = Chirp::with('user')
            ->when($search, function ($query, $search) {
                $query->where('message', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('home', compact('chirps', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect('/')->with('success', 'Chirp created!');
    }

   public function edit(Chirp $chirp)
{
    $this->authorize('update', $chirp); 
    
    return view('chirps.edit', compact('chirp'));
}
public function update(Request $request, Chirp $chirp)
{
    $this->authorize('update', $chirp); // <- use Policy, not if

    $validated = $request->validate([
        'message' => ['required','string','max:255'],
    ]);

    $chirp->update($validated);

    return redirect('/')->with('success', 'Chirp updated!');
}

    // Exercise 2
   public function destroy(Chirp $chirp)
{
    $this->authorize('delete', $chirp);
    $chirp->delete();
    return redirect('/')->with('success', 'Chirp deleted!');
}

   //exercise4
   public function trash()
{
    $chirps = Chirp::onlyTrashed()->where('user_id', auth()->id())->latest()->get();
    return view('chirps.trash', ['chirps' => $chirps]);
}

public function restore($id)
{
    $chirp = Chirp::onlyTrashed()->findOrFail($id);
    $this->authorize('delete', $chirp);
    $chirp->restore();
    return redirect()->route('chirps.trash')->with('success', 'Chirp restored!');
}

public function forceDelete($id)
{
    $chirp = Chirp::onlyTrashed()->findOrFail($id);
    $this->authorize('delete', $chirp);
    $chirp->forceDelete();
    return redirect()->route('chirps.trash')->with('success', 'Chirp deleted permanently!');
}
}