<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        // hơư to pass data 
        $title = "How to lam chu laravel trong 9 ngay";
        $name = "Tlinh";
        // return view('blog.index', compact('title'))->with('name', $name);
        // send an associative array
        $myphone = [
            'name' => 'iphone 12',
            'year' => 2024,
            'isFavorite' => true
        ];

        return view('blog.index', compact('myphone', 'title', 'name'));
    }

    public function detail($id){
        $blogList = [
            "1" => 'Cách đẹp trai nhanh như Linh',
            "2" => 'Cách làm rau muống xào thiên lý'
        ];
        return view('blog.index', [
            'blog' => $blogList[$id] ?? "unknown"
        ]);
    }
}
