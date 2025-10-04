<?php

use App\Livewire\Auth\Register;
use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('sends email verification notification on registration', function () {
    Notification::fake();

    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('terms', true)
        ->call('register');

    $user = User::where('email', 'test@example.com')->first();

    expect($user)->not->toBeNull();

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('verifies email with valid link', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user, 'tenant');

    $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]
    );

    $this->get($verificationUrl)->assertRedirect(route('tenant.dashboard'));

    $user->refresh();

    expect($user->hasVerifiedEmail())->toBeTrue();
});