<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Category;
use Auth;

class CategoriesController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return redirect('/')->with('error', 'Unauthorized access');
        }

        if(!Auth::user()->admin){
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $categories = Category::all();

        return view('categories.index')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = new Category();
        $category->name = $request['name'];
        $category->save();

        return redirect('/admin/categories')->with('success', 'Category added!');
    }

    /**
     * Delete selected categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(request $request)
    {

        if(isset($request['itemsToDelete'])){

            foreach($request['itemsToDelete'] as $id){
                $category = Category::find($id);
                $category->delete();
            }
            return redirect('/admin/categories')->with('success', 'Item(s) Deleted');
        }
        else{
            return redirect('/admin/categories')->with('error', 'Select at least one item to delete');
        }

    }
}
