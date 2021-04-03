<?php

use App\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat-channel', function ($user) {
    return [
        'user_id' => $user->user_id,
        'name' => $user->name
    ];
});

Broadcast::channel('admin-{user_id}', function ($user, $user_id) {
    return ($user->user_id === $user_id) || (User::find($user->user_id)->roles->role === 'admin');
});