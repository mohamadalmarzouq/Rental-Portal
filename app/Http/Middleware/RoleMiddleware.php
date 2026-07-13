<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $current_route_name = $request->route()->getName();
        $route_segments = explode('.', $current_route_name);

        $module_name = $route_segments[0];
        $module_method = isset($route_segments[1]) ? $route_segments[1] : '';

        if (!in_array($module_name, $this->whiteListModuleNames())) {


            if (in_array($module_method, $this->blacklistedModuleActions())) {

                $key = $module_method == 'view' ? 'show' : $module_method;

            } else if (hasRole($module_name, 'bypass_visibility')) {
                return $next($request);
            } else {

                $key = 'is_visible';

            };

            $has_permission = hasRole($module_name, $key);

            if (!$has_permission) {
                abort(403);
            }
        }


        return $next($request);
    }

    public function whiteListModuleNames()
    {
        return [
            'home',
            'languages.language',
            'languages.edit',
            'search',
            'notification',
            'update_profile',
            'profile',
            'update_notification',
            'notification'
        ];
    }

    public function blacklistedModuleActions()
    {
        return [
            'add',
            'show',
            'view',
            'edit',
            'delete',
            'update'
        ];
    }
}
