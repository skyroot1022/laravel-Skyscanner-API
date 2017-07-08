<?php

namespace App\Http\Controllers;

use App\Facades\SkyScanner;
use App\Flight;
use App\Group;
use App\Vote;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    public function addVoteForFlight(Request $request)
    {
        if (Vote::where('user_id', \Cookie::get('uuid'))->where('flight_id', $request->get('flight_id'))->count() < 1 ) {

            $vote =  new Vote();
            $vote->flight_id = $request->get('flight_id');
            $vote->user_id = \Cookie::get('uuid');
            $vote->type = $request->has('negative') ? 1:0;
            $vote->save();
        } else {
            return response('Already voted, fkcouop', 500);
        }

        return response('OK', 200);
    }


    public function showDestinations(Request $request)
    {

        return SkyScanner::destination(strlen($request->get('q', 'u')) < 1 ? 'u' : $request->get('q', 'u'))->Places;
    }

    public function getResultsViewHtml(Request $request)
    {

        $group = Group::wherePublicId($request->get('pid'))->first();

        $html = '';

        foreach ($group->getFlightsByVoteCount() as $flight) {

            $html .= view('partials.result-row', ['flight' => $flight])->render();

        }

        return [
            'html' => $html
        ];
    }
}
