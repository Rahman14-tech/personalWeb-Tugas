<?php

namespace App\Http\Controllers;

use App\Models\portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function index(Request $request)
    {
        $Website = DB::table('portfolios')->where('category_id','=',1)->get();
        $App = DB::table('portfolios')->where('category_id','=',2)->get();
        $Certificate = DB::table('portfolios')->where('category_id','=',4)->get();
        $Community = DB::table('portfolios')->where('category_id','=',5)->get();
        return view('display',[
            'Website'=>$Website,
            'App'=>$App,
            'Certificate'=>$Certificate,
            'Community'=>$Community,
        ]);
    }
    public function admin(Request $request)
    {
        $collection = portfolio::all();
        return view('adminDashboard',[
            'collection' => $collection,
        ]);
    }
    public function myLogout(Request $request)
    {
        $request->session()->flush();

        Auth::logout();

        return redirect('login');
    }
}
