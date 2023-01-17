<?php
declare(strict_types=1);
namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

class CustomClientSite
{

    private const SUPER_ADMIN_ROLE_ID = [
      3
    ];
    private const ADMIN_ROLE_ID = [
      2,
      3
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        View::share('profil', Auth::user());

        Gate::define('isSuperAdmin', function (User $user) {
            return (bool) in_array($user->role_id, SELF::SUPER_ADMIN_ROLE_ID);
        });

        Gate::define('userChangePermissions', function (User $user, User $employee) {
            if (in_array($user->role_id, SELF::ADMIN_ROLE_ID ) & $user->group_id === $employee->group_id || Gate::any('isSuperAdmin')) {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('myAccount', function (User $user, int $id) {
            if ($user->id === $id) {
                return true;
            } else {
                return false;;
            }
        });

        $superAdmin = Gate::any('isSuperAdmin');

        View::share('superAdmin', $superAdmin);
        return $next($request);
    }
}
