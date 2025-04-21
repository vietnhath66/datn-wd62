<?php

namespace App\Console;

use App\Console\Commands\CancelExpiredPendingOrders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        CancelExpiredPendingOrders::class,
    ];


    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('orders:cancel-expired-pending')
            // ->everyFiveMinutes(); // Hoặc 5 phút 1 lần nếu muốn nhanh hơn
            ->hourly() // Chạy hàng giờ
            // ->dailyAt('01:00'); // Chạy vào 1h sáng mỗi ngày
            ->withoutOverlapping(); // Đảm bảo không chạy chồng chéo
    }


    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
