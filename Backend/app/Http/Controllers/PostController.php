<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Todo;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
            'created_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }


        $todo = new Todo();

        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->created_by = $request->created_by;

        if ($todo->save()) {

            return response()->json(['status' => true, 'todo' => $todo], 201);
        } else {
            return response()->json(['status' => false, 'message' => 'oops, todo could not be save'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {



        $posts = DB::table('todos')
            ->select('todos.title', 'todos.body', 'todos.id', 'todos.created_by')
            ->get();


        foreach ($posts as $post) {
            $post->commentaires = DB::table('commentaires')->where('id_post', '=', $post->id)->get();
            $post->name = DB::table('users')->select('name')->where('id', '=', $post->created_by)->get();
        }

        // $product = Todo::all();
        // DB::raw('commentaires.body as commentaire_body'), DB::raw('commentaires.id as commentaire_id'),

        if (is_null($posts)) {
            return $this->sendError('Post not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "Post retrieved successfully.",
            "data" => $posts
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
            'created_by' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }

        $post = Todo::findOrFail($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->created_by = $request->created_by;

        if ($post->save()) {
            return response()->json(['status' => true, 'post' => $post], 201);
        } else {
            return response()->json(['status' => false, 'message' => 'oops, todo could not be updated'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (Todo::destroy($id)) {
            return response()->json(['status' => "post supprimer"], 400);
        } else {
            return response()->json(['status' => "post not supprimer"], 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function  showAllPostWithName()
    {

        $posts = DB::table('todos')
            ->join('users', 'todos.created_by', '=', 'users.id')
            ->select('users.name', 'todos.title', 'todos.body', 'todos.id')
            ->get();
        return response()->json(['data' => $posts], 201);
    }
}