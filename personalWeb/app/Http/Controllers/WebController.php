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
        $Website = DB::table('portfolios')->where('category_id', '=', 1)->get();
        $App = DB::table('portfolios')->where('category_id', '=', 2)->get();
        $Certificate = DB::table('portfolios')->where('category_id', '=', 3)->get();
        $Community = DB::table('portfolios')->where('category_id', '=', 4)->get();
        $Category = DB::table('categories')->get();
        return view('display', [
            'Website' => $Website,
            'App' => $App,
            'Certificate' => $Certificate,
            'Community' => $Community,
            'Category' => $Category,
        ]);
    }
    public function admin(Request $request)
    {
        $collection = portfolio::all();
        return view('adminDashboard', [
            'collection' => $collection,
        ]);
    }
    public function myLogout(Request $request)
    {
        $request->session()->flush();

        Auth::logout();

        return redirect('login');
    }
    public function portView(Request $request, $id)
    {
        $Data = DB::table('portfolios')->where('id', '=', $id)->get();
        return view('portfoliosView', [
            'Data' => $Data,
        ]);
    }
}