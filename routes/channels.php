<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    Log::info('Broadcast auth attempt for user: '.$user->id.' to channel: '.$id);

    return (int) $user->id === (int) $id;
});
