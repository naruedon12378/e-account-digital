<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use PDO;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index(Request $request){

        $member_total = User::WhereHas('roles', function($q){ $q->where('name', '=' , 'user'); })->count();
        $user_total = User::WhereHas('roles', function($q){ $q->where('name', '!=', 'developer'); })->count();
        $article_total = Article::count();

        return view('admin.dashboard', compact('member_total', 'user_total', 'article_total'));
    }
}