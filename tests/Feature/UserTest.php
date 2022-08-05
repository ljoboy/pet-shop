<?php

use App\Models\User;

test('admin can create admin user', function () {
    $user = User::factory()->raw();
    $user['password_confirmation'] = 'userpassword';
    $this->route .= '/create';
    $response = $this->postJSon($this->route, $user);

    $response->assertStatus(Response::HTTP_CREATED)->assertJson(['success' => 1]);
    $this->assertDatabaseHas('users', $user);
});
