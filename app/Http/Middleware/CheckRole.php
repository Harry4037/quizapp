<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class CheckRole {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $role) {

        if (!$request->user()->hasRole($role)) {
            abort(404, "Unaurthorized User.");
        }
        if (!session()->has('menus')) {
            $menus = Menu::where("parent_id", 0)->get();
            $menuData = [];
            if ($menus) {
                foreach ($menus as $k => $menu) {
                    $childMenu = Menu::where("parent_id", $menu->id)->get();
                    $menuData[$k]['menu_name'] = $menu->description;
                    $menuData[$k]['menu_icon'] = $menu->icon;
                    $menuData[$k]['menu_link'] = $menu->link;
                    if ($childMenu->count()) {
                        foreach ($childMenu as $j => $child) {
                            $menuData[$k]['child_menu'][$j]['menu_name'] = $child->description;
                            $menuData[$k]['child_menu'][$j]['menu_icon'] = $child->icon;
                            $menuData[$k]['child_menu'][$j]['menu_link'] = $child->link;
                        }
                    } else {
                        $menuData[$k]['child_menu'] = [];
                    }
                }
            }
            session()->push("menus", $menuData);
        }
        return $next($request);
    }

}
