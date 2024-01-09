<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        return inertia(
            'Index/Index'
        );
    }

    public function show()
    {
        return inertia('Index/Show');
    }
}
