<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 16/08/2015
 * Time: 10:01
 */

namespace ineluctable\repositories;


use ineluctable\models\EveSolarSystem;

class SolarSystemRepository
{
    /**
     * Gets a list of all solarsystems
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return EveMap::where('typeID', 5)->get();
    }

    public function findByID($id)
    {
        return EveMap::where('typeID', 5)->where('itemID', $id)->get();
    }

    public function findByName($name)
    {
        return EveMap::where('typeID', 5)->where('itemName', $name)->get();
    }
}