<?php

namespace ineluctable\Http\Controllers;

use Illuminate\Http\Request;

use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;

class ApiKeyCharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($apikeyid)
    {
        return 'list all the characters for this api key:'.$apikeyid;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($apikey, $id)
    {
        return 'show the character from apikey:'.$apikey.' with the character id:'.$id;
    }


    public function skillintraining($apikey, $id)
    {
        return 'show the character skill in training from apikey:'.$apikey.' with the character id:'.$id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
