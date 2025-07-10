<?php

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
use App\Models\User;

test('authenticated user can access employee index page', function () {
    $user = User::factory()->create([
        'role' => 'admin', // or whatever role is authorized
    ]);

    $response = $this
        ->actingAs($user, 'web')
        ->get('/employees');

    $response->assertOk();
});

