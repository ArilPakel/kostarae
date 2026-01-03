<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogin
{
    // Inject Request untuk ambil IP & Browser
    public function __construct(public Request $request)
    {
    }

    public function handle(Login $event)
    {
        // Catat aktivitas Login
        activity()
            ->causedBy($event->user) // Siapa yang login
            ->withProperties([
                'ip' => $this->request->ip(),
                'agent' => $this->request->userAgent()
            ])
            ->log('Masuk ke dalam sistem (Login)');
    }
}