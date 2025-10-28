<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:view users'])->only('index');
        $this->middleware(['auth','permission:create users'])->only(['create','store']);
        $this->middleware(['auth','permission:edit users'])->only(['edit','update']);
        $this->middleware(['auth','permission:delete users'])->only('destroy');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // other methods: create, store, edit, update, destroy...
}
