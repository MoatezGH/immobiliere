<?php

namespace App\Listeners;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
class UpdateLastLogin
{
    public function handle(Login $event)
    {
        $event->user->last_login = now();
        $event->user->save();
    }
}
