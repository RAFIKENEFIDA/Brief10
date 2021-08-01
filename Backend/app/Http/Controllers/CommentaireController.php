<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Commentaire;
use App\Http\Controllers\Controller;

class CommentaireController extends Controller
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
            'id_user' => 'required',
            'body' => 'required|string',
            'id_post' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }


        $commentaire = new Commentaire();
        $commentaire->body = $request->body;
        $commentaire->id_user = $request->id_user;
        $commentaire->id_post = $request->id_post;

        if ($commentaire->save()) {

            return response()->json(['status' => true, 'commentaire' => $commentaire], 201);
        } else {
            return response()->json(['status' => false, 'message' => 'commentaire not register'], 400);
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

        $commentaires = Commentaire::all();
        if (is_null($commentaires)) {
            return $this->sendError('commentaires not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "commentaires retrieved successfully.",
            "data" => $commentaires
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
        //
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
            'id_user' => 'required',
            'body' => 'required|string',
            'id_post' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }


        $commentaire = Commentaire::findOrFail($id);
        $commentaire->body = $request->body;
        $commentaire->id_user = $request->id_user;
        $commentaire->id_post = $request->id_post;

        if ($commentaire->save()) {
            return response()->json(['status' => true, 'commentaire' => $commentaire], 400);
        } else {
            return response()->json(['status' => false, 'message' => 'oops, commentaire could not be updated'], 400);
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
        if (Commentaire::destroy($id)) {
            return response()->json(['status' => "post supprimer"], 201);
        } else {
            return response()->json(['status' => "post not supprimer"], 400);
        }
    }
}