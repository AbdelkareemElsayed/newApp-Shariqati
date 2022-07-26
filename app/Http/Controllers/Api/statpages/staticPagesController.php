<?php

namespace App\Http\Controllers\Api\statpages;

use App\Http\Controllers\Controller;
use App\Models\dashboard\staticpages\staticPages;

class staticPagesController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        # Fetch Data . . . 
        $pages = staticPages::orderByDesc('id')->select('id', 'slug')->get();

        # Fetch Count . . . 
        $count = $pages->count();
        return response()->json(['data' => $pages, 'count' => $count], 200);
    }

    ########################################################################################################################

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $page = staticPages::where('slug', $slug)->with('content')->with('keywords')->get()
            ->map(function (staticPages $page) {
                $page->image = asset('storage/' .$page->image);
                return $page;
            });


        return response()->json(['data' => $page], 200);
    }

    ########################################################################################################################
}
