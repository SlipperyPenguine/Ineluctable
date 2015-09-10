<?php

namespace ineluctable\models;

use Illuminate\Database\Eloquent\Model;

class EveRegion extends \Eloquent
{
    protected $table = 'mapDenormalize';

    public $timestamps = false;

    //note this will return both constellations 4 and system 5.  Need to filter inside the repository
    public function solarsystems()
    {
        return $this->hasMany('ineluctable\models\EveSolarSystem', 'itemName', 'regionID')->where('typeID, 5');
    }
}