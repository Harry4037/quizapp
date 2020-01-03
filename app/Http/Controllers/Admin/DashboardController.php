<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;

class DashboardController extends Controller {

    public function index(Request $request) {

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
        $request->session()->remove("menus");
        $request->session()->push("menus", $menuData);

        // $product = Product::whereNull("deleted_at")->count();
        // $freeMealCount = FreeMealProduct::whereHas("product", function($query) {
        //     $query->whereNull("deleted_at");
        // })->whereHas("product", function($query) {
        //     $query->where("is_active", 1);
        // })->count();
        $usersCount = User::where('user_type_id', 3)->count();
        $staffCount = User::where('user_type_id', 2)->count();
        return view('admin.dashboard.index', [
            // 'productCount' => $product,
            'usersCount' => $usersCount,
            'staffCount' => $staffCount,
            // 'freeMealCount' => $freeMealCount,
        ]);
    }

}
