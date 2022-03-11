<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use App\Models\User;

class RedirectIfUserBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // Redirects user to the blocked account message
        $is_user_active = User::select('is_active')->where('id', auth()->id())->pluck('is_active');

        foreach($is_user_active as $is_active) {
            if($is_active !== 1) {
                return redirect('account-blocked');
            }
        }
        
        return $next($request);
    }
}
