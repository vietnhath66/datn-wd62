<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            // Nếu bạn không muốn gửi email xác thực qua Registered event,
            // bạn có thể bỏ SendEmailVerificationNotification::class ở đây
            // và gọi $user->sendEmailVerificationNotification() thủ công trong RegisteredUserController.
        ],
        Verified::class => [ // Lắng nghe sự kiện Verified khi user xác thực email
            UpdateUserStatusOnVerified::class, // THÊM DÒNG NÀY
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
