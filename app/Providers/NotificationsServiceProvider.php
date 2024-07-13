<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\tblNotification;
use App\Models\tblUserNotification;

use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //for Navbars
        View::composer('layouts.admin-components.navigation', function ($view) {
            $userNotifications = tblNotification::where('userId', auth()->id())->get() ?? [];
            $view->with('userNotifications', $userNotifications);
        });
        View::composer('layouts.staff-components.navigation', function ($view) {
            $userNotifications = tblNotification::where('userId', auth()->id())->get() ?? [];
            $view->with('userNotifications', $userNotifications);
        });
        View::composer('layouts.user-components.navigation', function ($view) {
            $userNotifications = tblUserNotification::where('userId', auth()->id())->get() ?? [];
            $view->with('userNotifications', $userNotifications);
        });

        //for NotifScreen
        View::composer('layouts.admin-components.notification', function ($view) {
            $userNotifications = tblNotification::where('userId', auth()->id())->get() ?? [];
            $view->with('userNotifications', $userNotifications);
        });
        View::composer('layouts.staff-components.notification', function ($view) {
            $userNotifications = tblNotification::where('userId', auth()->id())->get() ?? [];
            $view->with('userNotifications', $userNotifications);
        });
        View::composer('layouts.user-components.notification', function ($view) {
            $userNotifications = tblUserNotification::where('userId', auth()->id())->get() ?? [];
            $view->with('userNotifications', $userNotifications);
        });
    }
}
