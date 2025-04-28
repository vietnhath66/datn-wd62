<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserStatusOnVerified
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
    public function handle(Verified $event): void
    {
        $user = $event->user;

        // Cập nhật trường status
        // Kiểm tra xem user có trường status không để tránh lỗi nếu cấu trúc DB thay đổi
        if (isset($user->status)) {
            $user->status = 'verified'; // Gán giá trị mới
            $user->save(); // Lưu lại vào database
        }
    }
}
