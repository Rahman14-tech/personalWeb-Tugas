<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPortfolioRequest;
use App\Models\portfolio;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = portfolio::all();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPortfolioRequest $request)
    {
        $portfolio = new portfolio;
        $image = $request->file('image')->store('post-images');
        $portfolio->title = $request->title;
        $portfolio->description = $request->description;
        $idForeign = DB::select('SELECT id FROM categories WHERE Category = :category', [':category' => $request->category]);
        $portfolio->category_id = $idForeign[0]->id;
        $portfolio->image_file_route = $image;
        $portfolio->save();
        return response('add portfolio success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}