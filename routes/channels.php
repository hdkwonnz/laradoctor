<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('appointment-status', function () {
//     return true; //이렇게 하지 말 것...
// });

// Broadcast::channel('appointment-status', function ($user) {
//     return ['name'=>$user->name];
// });
//위 와 아래 모두 가능 함...
Broadcast::channel('appointment-status', function ($user) { //for alert message
    return $user;
});

Broadcast::channel('patient-status', function ($user) { //for arrival status
    return $user;
});