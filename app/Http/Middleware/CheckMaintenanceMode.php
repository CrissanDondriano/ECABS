<?php

namespace App\Http\Middleware;

use App\Models\tblSettings;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $maintenanceSettings = tblSettings::where('name', 'maintenanceMode')->firstOrFail();

        // Check if maintenance mode is enabled
        if (!$maintenanceSettings->value == 1) {
            // Check if there is an authenticated user
            if (auth()->check()) {
                $user = auth()->user();
                
                // Check if the user is in the 'user' or 'staff' role
                if ($user->type === 'user' || $user->type === 'staff') {
                    return response()->view('partials.maintenance');
                }
            }
        }

        return $next($request);
    }

}
