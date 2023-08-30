<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){ 
        // $results = Post::join("comments", "posts.id", "=", "comments.post_id")
        // ->select("posts.title", "comments.body")
        // ->where("comments.body", "like", "%laudanti%")
        // ->get();

        // $combined_results = [];

        // foreach ($results as $value) {
        //     if (isset($combined_results[$value['title']])) {
        //         $combined_results[$value['title']]['body'] .= '\n' . $value['body'];
        //     }
        //     else {
        //         $combined_results[$value['title']] = array(
        //             'title' => $value['title'],
        //             'body' => $value['body']
        //         );
        //     }
        // }
        
        // dd("123");
        return view("home");
    }

    public function search(Request $request){
        if(strlen($request->search_text) < 3){
            return response()->json(null);
        }
        
        $results = Post::join("comments", "posts.id", "=", "comments.post_id")
        ->select("posts.title", "comments.body")
        ->where("comments.body", "like", "%{$request->search_text}%")
        ->get();

        $combined_results = [];

        foreach ($results as $value) {
            if (isset($combined_results[$value['title']])) {
                $combined_results[$value['title']]['body'] .= '<br><br>' . $value['body'];
            }
            else {
                $combined_results[$value['title']] = array(
                    'title' => $value['title'],
                    'body' => $value['body']
                );
            }
        }

        $combined_results = array_values($combined_results);

        return response()->json($combined_results);
    }
}
