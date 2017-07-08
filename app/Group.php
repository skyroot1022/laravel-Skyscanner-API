<?php

namespace App;

use App\Facades\SkyScanner;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function  getFlightsByVoteCount()
    {
        return $this->flights()->orderBy('price','desc')->get()->sortByDesc(function($hackathon)
        {
            return  $hackathon->voteCountNormalized();
        });
    }

    public function refresh()
    {
        $s = SkyScanner::getCheapest($this->from);

        foreach ($s->Quotes as $quote) {

            if (Flight::where('group_id', $this->id)->where('quote_id', $this->id)->count() > 0) {
                continue;
            }

            $flight = new Flight();
            $flight->group_id = $this->id;
            $flight->quote_id = $quote->QuoteId;
            $flight->price = $quote->MinPrice;
            $flight->dateFrom = Carbon::parse($quote->OutboundLeg->DepartureDate);
            $flight->dateTo = Carbon::parse($quote->InboundLeg->DepartureDate);
            $flight->from_id = $quote->OutboundLeg->OriginId;
            $flight->to_id = $quote->InboundLeg->OriginId;

            foreach ($s->Places as $place) {
                if ($place->PlaceId == $flight->from_id) {
                    $flight->from = $place->name;
                }
                if ($place->PlaceId == $flight->to_id) {
                    $flight->to = $place->name;
                }
            }
            $flight->save();

        }

    }

    public function comments()
    {
      return $this->hasMany(Comment::class);
    }
}
