<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\portfolio;
use App\Models\portofolios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Configuration\Builder;
use File;

class portofolioController extends Controller
{
    //  /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index(Request $request)
    {
        $requestName = $request->get('q');
        if ($requestName == 'community') {
            $category = DB::table('categories')->where('Category', '=', 'Community Services')->get();
            $community = DB::table('portfolios')->where('category_id', '=', $category[0]->id)->get();
            return view('portofolios.indexCommunity', [
                'community' => $community,
            ]);
        }
        $portofolios = portfolio::all();
        return view('portofolios.index', [
            'portofolios' => $portofolios
        ]);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function create(Request $request)
    {
        $requestName = $request->get('q');
        if ($requestName == 'Community') {
            return view('portofolios.addCommunity', [
                'categoryData' => 'Community Services',
            ]);
        }
        // $categoryData = Category::all();
        $categoryData = DB::table('categories')->whereNot(function ($query) {
            $query->where('Category', 'Community Services');
        })->get();
        return view('portofolios.addPortofolio', [
            'categoryData' => $categoryData,
        ]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        $requestName = $request->get('q');
        if ($requestName != '' && $requestName != null) {
            $id = (int) $requestName;
            $porto = DB::table('portfolios')->where('id', '=', $id)->get();
            $imageUpdate = $request->file('image')->store('post-images');
            File::delete('storage/' . $porto[0]->image_file_route);
            $affectedRecords = portfolio::where("id", $id)->update(["image_file_route" => $imageUpdate]);
            return redirect('admin');
        }
        $portfolio = new portfolio;
        $image = $request->file('image')->store('post-images');
        $portfolio->title = $request->title;
        $portfolio->description = $request->description;
        $idForeign = DB::select('SELECT id FROM categories WHERE Category = :category', [':category' => $request->category]);
        $portfolio->category_id = $idForeign[0]->id;
        $portfolio->image_file_route = $image;
        $portfolio->save();
        return redirect('admin');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    // //  */
    public function show($id, Request $request)
    {
        $porto = DB::table('portfolios')->where('id', '=', $id)->get();
        if ($request->file('image') != null && $request->file('image') != '') {
            $imageUpdate = $request->file('imageUpdate')->store('post-images');
            File::delete('storage/' . $porto[0]->image_file_route);
            $affectedRecords = portfolio::where("id", $id)->update(["image_file_route" => $imageUpdate]);
        }
        if ($request->titleUpdate != null && $request->titleUpdate != '') {
            $affectedRecords = portfolio::where("id", $id)->update(["title" => $request->titleUpdate]);
        }
        if ($request->description != null && $request->description != '') {
            $affectedRecords = portfolio::where("id", $id)->update(["description" => $request->description]);
        }
        if ($request->category != null && $request->category != '') {
            $idForeign = DB::select('SELECT id FROM categories WHERE Category = :category', [':category' => $request->category]);
            $affectedRecords = portfolio::where("id", $id)->update(["category_id" => $idForeign[0]->id]);
        }
        return redirect('admin');
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $pastData = DB::table('portfolios')->where('id', '=', $id)->get();
        $categoryData = Category::all();
        return view('portofolios.updatePortfolios', [
            'categoryData' => $categoryData,
            'pastData' => $pastData,
            'id' => $id,
        ]);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, $id)
    {
        $porto = DB::table('portfolios')->where('id', '=', $id)->get();
        if ($request->file('imageUpdate') != null && $request->file('imageUpdate') != '') {
            $imageUpdate = $request->file('imageUpdate')->store('post-images');
            File::delete('storage/' . $porto[0]->image_file_route);
            $affectedRecords = portfolio::where("id", $id)->update(["image_file_route" => $imageUpdate]);
        }
        if ($request->title != null && $request->title != '') {
            $affectedRecords = portfolio::where("id", $id)->update(["title" => $request->title]);
        }
        if ($request->description != null && $request->description != '') {
            $affectedRecords = portfolio::where("id", $id)->update(["description" => $request->description]);
        }
        if ($request->category != null && $request->category != '') {
            $affectedRecords = portfolio::where("id", $id)->update(["category_id" => $request->category]);
        }
        return redirect('admin');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($id)
    {
        $porto = DB::table('portfolios')->where('id', '=', $id)->get();
        File::delete('storage/' . $porto[0]->image_file_route);
        DB::delete('DELETE from portfolios WHERE id = ?', [$id]);
        return redirect('admin');
    }
}