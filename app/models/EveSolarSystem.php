<?php

namespace ineluctable\models;

use Illuminate\Database\Eloquent\Model;

class EveSolarSystem extends \Eloquent
{
    protected $table = 'mapDenormalize';

    public $timestamps = false;

    public function region()
    {
        return $this->belongsTo('ineluctable\models\EveRegion', 'regionID', 'itemID');
    }

    public function getRegion()
    {
        return $this->region()->first();
    }

    public function getDotlanURL()
    {
        $solarsystem = $this->itemName;
        $region = $this->region()->first()->itemName;
        return "http://evemaps.dotlan.net/map/".str_replace(' ','_', $region)."/".$solarsystem;
    }
}
