<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('index');
    }

    public function about(){
        return view('about');
    }

    public function services(){
        $services = ['Web Design', 'Development', 'Something'];

        return view('services')->with('services', $services);
    }
}
