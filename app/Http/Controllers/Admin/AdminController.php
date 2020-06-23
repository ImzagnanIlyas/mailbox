<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){

        $user = auth()->user();
        $roles = $user->getRoleNames();

        foreach ($roles as $role){
            if ($role == "admin" || $role == "moderator"){
                return view('Admin/admin');
            }
        }
        return '<h3>Vous ne pouvez pas accéder à cet espace</h3><a href=/inbox>cliquer ici pour retourner</a>';
    }
}
