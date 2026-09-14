 <?php

use App\Models\Chirp;
use App\Models\User;

test('owner can delete chirp', function () {
    $user = User::factory()->create();
    $chirp = Chirp::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->delete(route('chirps.destroy', $chirp))
        ->assertRedirect('/');

    $this->assertSoftDeleted($chirp);
});

test('guest cannot delete chirp', function () {
    $chirp = Chirp::factory()->create();
    $this->delete(route('chirps.destroy', $chirp))->assertRedirect('/login');
});

test('user cannot delete others chirp', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $chirp = Chirp::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($other)
        ->delete(route('chirps.destroy', $chirp))
        ->assertForbidden();
});