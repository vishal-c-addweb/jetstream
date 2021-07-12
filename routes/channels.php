<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('home', function ($user) {
    // verify that user is recipient of message
    return \Auth::check();
  });

Broadcast::channel('chat', function ($user) {
// verify that user is recipient of message
    return $user;
});

Broadcast::channel('chats', function ($user) {
    // verify that user is recipient of message
        return $user;
});

Broadcast::channel('conversation', function ($user) {
    // verify that user is recipient of message
        return $user;
});

Broadcast::channel('groupchat', function ($user) {
    // verify that user is recipient of message
        return $user;
});

Broadcast::channel('presence-video-channel', function($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('agora-online-channel', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});