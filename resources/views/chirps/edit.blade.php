 <x-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="font-bold text-xl mb-4">Edit Chirp</h2>
       
        <form method="POST" action="{{ route('chirps.update', $chirp) }}">
            @csrf
            @method('PUT')
           
            <textarea
                name="message"
                class="textarea textarea-bordered w-full"
                rows="3"
            >{{ old('message', $chirp->message) }}</textarea>
           
            @error('message')
                <p class="text-sm text-error mt-2">{{ $message }}</p>
            @enderror
           
            <div class="mt-4 flex gap-2">
                <a href="/" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Chirp</button>
            </div>
        </form>
    </div>
</x-layout>