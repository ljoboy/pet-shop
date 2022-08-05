<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->route = '/api/v1/admin';
});

test('admin@buckhill.co.uk exist', function () {
    $this->assertDatabaseHas('users', [
        'email' => 'admin@buckhill.co.uk',
    ]);
});

test('admin can login', function () {
    $this->route .= '/login';
    $response = $this->postJSon($this->route, [
        'email' => 'admin@buckhill.co.uk',
        'password' => 'admin',
    ]);

    $response->assertStatus(Response::HTTP_OK)->assertJson(['success' => 1]);
});

test('admin with bad params got error', function () {
    $this->route .= '/login';
    $response = $this->postJSon($this->route, [
        'email' => 'admin@buckhill.co.uk',
        'password' => 'password',
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson(['success' => 0, 'error' => 'failed to authenticate user']);
});

test('admin without one param got error', function () {
    $this->route .= '/login';
    $response = $this->postJSon($this->route, [
        'email' => 'admin@buckhill.co.uk',
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

test('user cant connect as admin', function () {
    $user = User::factory()->create();
    $this->route .= '/login';
    $response = $this->postJSon($this->route, [
        'email' => $user->email,
        'password' => $user->password,
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});
