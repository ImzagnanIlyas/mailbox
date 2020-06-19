<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UserEmail;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class EmailsController extends Controller
{
    public function index()
    {
        return response()->json(
            UserEmail::All()->where('state', 'sent')
        );
    }
}
