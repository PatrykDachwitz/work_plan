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
    private const ID_ROLE_SUPER_ADMIN = 2;
    private const ID_ROLE_ADMIN = 1;

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
            return (bool) ($user->role_id === SELF::ID_ROLE_SUPER_ADMIN);
        });

        Gate::define('updateData', function (User $user, User $employee) {
            return (bool) (
                Gate::any('isSuperAdmin')
                    |
                $employee->group_id === $user->group_id & $user->role_id === SELF::ID_ROLE_ADMIN
            );
        });

        Gate::define('mySelf', function (User $user, int $id) {
            return (bool) ($user->id === $id);
        });

        $superAdmin = Gate::any('isSuperAdmin');

        View::share('superAdmin', $superAdmin);
        return $next($request);
    }
}
