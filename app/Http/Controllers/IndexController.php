<?php

namespace App\Http\Controllers;

use App\Facades\SkyScanner;
use App\Flight;
use App\Group;
use App\Comment;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', [

        ]);
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
    public function store(Requests\IndexRequest $request)
    {
        $group = new Group();

        $group->public_id = strtoupper(str_random(2 ));
        $group->name = $request->get('name', 'lol');
        $group->from = str_replace('-sky',  '', $request->get('from'));
        $group->save();

        $s = SkyScanner::getCheapest($group->from);

        foreach ($s->Quotes as $quote) {

            $flight = new Flight();
            $flight->group_id = $group->id;
            $flight->quote_id = $quote->QuoteId;
            $flight->price = $quote->MinPrice;
            $flight->dateFrom = Carbon::parse($quote->OutboundLeg->DepartureDate);
            $flight->dateTo = Carbon::parse($quote->InboundLeg->DepartureDate);
            $flight->from_id = $quote->OutboundLeg->OriginId;
            $flight->to_id = $quote->InboundLeg->OriginId;

            foreach ($s->Places as $place) {
                if ($place->PlaceId == $flight->from_id) {
                    $flight->from = $place->Name;
                    $flight->from_id = $place->IataCode;
                }
                if ($place->PlaceId == $flight->to_id) {
                    $flight->to = $place->Name;
                    $flight->to_id = $place->IataCode;
                }
            }

            $flight->save();

        }

        return redirect()->action('IndexController@showGroup', $group->public_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGroup($id)
    {


        $group = Group::wherePublicId($id)->first();

        if (Input::has('refresh')) {
            $group->refresh();
        }

        $comments = $group->comments()->orderBy('id', 'desc')->get();
        return view('results', [
            'data' => $group,
            'comments' => $comments,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {


    }
}
