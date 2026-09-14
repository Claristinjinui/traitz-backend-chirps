 <x-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Trash - Deleted Chirps</h1>
            <a href="/" class="btn btn-sm btn-ghost">Back to Feed</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($chirps->isEmpty())
            <div class="card bg-base-100 shadow">
                <div class="card-body text-center py-12">
                    <p class="text-gray-500">No deleted chirps. Trash is empty.</p>
                    <a href="/" class="link mt-2">Go back to feed</a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach($chirps as $chirp)
                    <div class="card bg-base-100 shadow">
                        <div class="card-body">
                            <p class="text-base-content">{{ $chirp->message }}</p>
                            <p class="text-sm text-gray-500 mt-2">
                                Deleted {{ $chirp->deleted_at->diffForHumans() }} •
                                Created {{ $chirp->created_at->diffForHumans() }}
                            </p>
                           
                            <div class="card-actions justify-end mt-4 gap-2">
                                <form method="POST" action="{{ route('chirps.restore', $chirp->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                </form>

                                <form method="POST" action="{{ route('chirps.forceDelete', $chirp->id) }}" onsubmit="return confirm('Delete permanently? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error">Delete Forever</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>