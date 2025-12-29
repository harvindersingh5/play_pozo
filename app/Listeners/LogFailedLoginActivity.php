<?php

namespace App\Listeners;

use App\Models\UserActivity;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogFailedLoginActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {

        $hash = md5(
            ($event->credentials['email'] ?? '') .
            request()->ip() .
            request()->userAgent() .
            now()->format('YmdHis')
        );

        if (cache()->has('failed_login_' . $hash)) {
            Log::info('⚠️ Duplicate failed login prevented', ['hash' => $hash]);
            return;
        }

        cache()->put('failed_login_' . $hash, true, 2);
        
        UserActivity::create([
            'user_id'    => null,
            'email'      => $event->credentials['email'] ?? null,
            'activity'   => 'Login Attempt',
            'status'     => 'failed',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
