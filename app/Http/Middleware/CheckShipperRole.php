<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckShipperRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role_id === 3) {
            // Nếu đúng là shipper, cho phép request đi tiếp đến Controller/View
            return $next($request);
        }

        return redirect('client/home')->with('error', 'Bạn không có quyền truy cập khu vực này.');
    }
}
