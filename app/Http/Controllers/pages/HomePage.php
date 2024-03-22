<?php

namespace App\Http\Controllers\pages;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePage extends Controller
{
  public function index()
  {
    $module_count = Module::where('is_active', 1)->count();
    $permission_count = Permission::where('is_active', 1)->count();
    // dd($module_count);
    return view('content.pages.pages-home', ['module_count' => $module_count, 'permission_count' => $permission_count]);
  }
}
