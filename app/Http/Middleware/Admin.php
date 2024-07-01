<?php

namespace App\Http\Middleware;

use App\Constants\RoleConstant;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Admin
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (auth()->check() && auth()->user()->role_id === RoleConstant::ADMIN_ROLE) {
            return $next($request);
        }
        return redirect()->to('/');
    }
}
