<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Resources\RatingResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RatingResource::collection(Rating::all());
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Rating::create($request->all());
        return response()->json([
          'data' => new RatingResource($data),
          'message' => 'Successfully added new event!',
          'status' => Response::HTTP_CREATED
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $rate = $request->rate;
        $comment = $request->comment;
        DB::update('update rating set rate = ?,comment=? where id = ?', [$rate,$comment,$id]);
        return response()->json([
          'message' => 'Successfully updated event!',
          'status' => Response::HTTP_ACCEPTED
      ]);
    }
}
