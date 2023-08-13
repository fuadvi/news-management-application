<?php

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use function Pest\Faker\fake;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    Artisan::call('passport:install');

    // Run seeders
    Artisan::call('db:seed');
});

test('it can get list news', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['user'])->accessToken;

    $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson('api/news')
        ->assertStatus(200)
        ->assertJsonStructure(
            [
                'message',
                'error',
                'code',
                'results' => ['news']
            ]
        );
});


test('it can create news', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['admin'])->accessToken;

    $images = UploadedFile::fake()->image('test_image.jpg');

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('api/news', [
        'title' => fake()->sentence(),
        'content' => fake()->paragraph(5),
        'category_id' => fake()->numberBetween(1, 5),
        'images' => $images,
        'user_id' => $user->id
    ])->assertJsonStructure(
        [
            'message',
            'error',
            'code',
            'results' => []
        ]
    );

    expect($response->status())->toBe(201);

});

test('it can create news return error when user role not admin', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['user'])->accessToken;

    $images = UploadedFile::fake()->image('test_image.jpg');

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('api/news', [
        'title' => fake()->sentence(),
        'content' => fake()->paragraph(5),
        'category_id' => fake()->numberBetween(1, 5),
        'images' => $images,
        'user_id' => $user->id
    ]);

    expect($response->status())->toBe(401);
    expect($response->json('message'))->toBe('Unauthorized');
});

test('it can update news', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['admin'])->accessToken;

    $news = News::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->putJson("api/news/{$news->slug}", [
        'title' => fake()->sentence(),
        'content' => fake()->paragraph(5),
        'category_id' => fake()->numberBetween(1, 5)
    ])->assertJsonStructure(
        [
            'message',
            'error',
            'code',
            'results' => []
        ]
    );

    expect($response->status())->toBe(200);
    expect($response->json('message'))->toBe('News Updated');
});


test('it can update news return error when user role not admin', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['user'])->accessToken;

    $news = News::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->putJson("api/news/{$news->slug}", [
        'title' => fake()->sentence(),
        'content' => fake()->paragraph(5),
        'category_id' => fake()->numberBetween(1, 5)
    ]);

    expect($response->status())->toBe(401);
    expect($response->json('message'))->toBe('Unauthorized');
});


test('it can delete news', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['admin'])->accessToken;

    $news = News::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->deleteJson("api/news/{$news->slug}");

    expect($response->status())->toBe(204);
});


test('it can delete news return error when user role not admin', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['user'])->accessToken;

    $news = News::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->deleteJson("api/news/{$news->slug}");

    expect($response->status())->toBe(401);
    expect($response->json('message'))->toBe('Unauthorized');
});

test('it can get news', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['admin'])->accessToken;

    $news = News::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson("api/news/{$news->slug}")->assertJsonStructure(
        [
            'message',
            'error',
            'code',
            'results' => []
        ]
    );

    expect($response->status())->toBe(200);
    expect($response->json('results')['title'])->toEqual($news->title);
});

test('it can comment news', function () {
    $user = User::factory()->create();
    $token = $user->createToken('UserToken', ['admin'])->accessToken;

    $news = News::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson("api/news/{$news->slug}/comment", [
        'content' => fake()->paragraph(1),
        'user_name' => $user->name,
        'user_id' => $user->id
    ]);

    expect($response->status())->toBe(200);

});
