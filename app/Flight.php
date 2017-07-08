<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $dates = ['dateFrom', 'dateTo'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function voteCountNormalized()
    {
        return $this->votes()->whereType(0)->count() - $this->votes()->whereType(1)->count();
    }

    public function skyScannerUrl()
    {
        return 'http://www.skyscanner.net/transport/flights/'. $this->from_id .'/'. $this->to_id .'/'. $this->dateFrom->format('Ymd') .'/#results';
    }
}
