<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use App\Http\Resources\CalendarResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CalendarResource::collection(Calendar::all());
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
        $new_calendar = Calendar::create($request->all());
        return response()->json([
            'message' => 'Successfully added new event!',
            'status' => Response::HTTP_CREATED
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $color = $request->color;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $event_name = $request->event_name;
        $id = $request->id;
        DB::update('update calendars set color = ?, start_date = ?, end_date = ?, event_name = ? where id = ?', [$color, $start_date, $end_date, $event_name, $id]);
        // $calendar->update($request->all());
        return response()->json([
            'message' => 'Successfully updated event!',
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Calendar $calendar)
    {
        $calendar::where('id', $request->id)->delete();
        // $calendar->delete();
        return response('Event removed successfully!', Response::HTTP_NO_CONTENT);
    }
}
