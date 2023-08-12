<?php

use App\Models\User;
use App\Repository\User\IUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
uses(Tests\TestCase::class)->in('Feature');

uses(RefreshDatabase::class);
beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    Artisan::call('passport:install');

    // Run seeders
    Artisan::call('db:seed');
});


test('it can register a user', function () {
    $this->postJson('api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'testpassword',
        'password_confirmation' => 'testpassword',
    ])->assertStatus(200)
        ->assertJsonStructure(
            [
                'message',
                'error',
                'code',
                'results' => ['user', 'token']
            ]
        );
});

test('it can login a user', function () {
    $user = User::factory()->create();

    $this->postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertStatus(200)
        ->assertJsonStructure(
            [
                'message',
                'error',
                'code',
                'results' => ['user', 'token']
            ]
        );
});

test('it returns an error when user not found', function () {
    $this->postJson('api/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'testpassword',
    ])->assertStatus(400)
        ->assertJson(['message' => 'User not found']);
});

test('it returns an error with incorrect password', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('testpassword'),
    ]);

    $this->postJson('api/login', [
        'email' => 'test@example.com',
        'password' => 'incorrectpassword',
    ])->assertStatus(400)
        ->assertJson(['message' => 'User not found']);
});

