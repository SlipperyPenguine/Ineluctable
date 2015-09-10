<?php

namespace ineluctable\Http\Controllers;

use App;
use Illuminate\Http\Request;

use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;
use ineluctable\models\EveAccountAPIKeyInfoCharacters;
use ineluctable\models\EveCharacterAssets;
use ineluctable\models\EveCharacterCharacterSheetSkills;
use ineluctable\models\EveCharacterContactList;
use ineluctable\models\EveCharacterContactListAlliance;
use ineluctable\models\EveCharacterContactListCorporate;
use ineluctable\models\EveCharacterContracts;
use ineluctable\models\EveCharacterIndustryJobs;
use ineluctable\models\EveCharacterKillMails;
use ineluctable\models\EveCharacterMailMessages;
use ineluctable\models\EveCharacterMailRecipients;
use ineluctable\models\EveCharacterMarketOrders;
use ineluctable\models\EveCharacterNotifications;
use ineluctable\models\EveCharacterPlanetaryColonies;
use ineluctable\models\EveCharacterPlanetaryPins;
use ineluctable\models\EveCharacterPlanetaryRoutes;
use ineluctable\models\EveCharacterResearch;
use ineluctable\models\EveCharacterSkillInTraining;
use ineluctable\models\EveCharacterSkillQueue;
use ineluctable\models\EveCharacterStandingsAgents;
use ineluctable\models\EveCharacterStandingsFactions;
use ineluctable\models\EveCharacterStandingsNPCCorporations;
use ineluctable\models\EveCharacterUpcomingCalendarEvents;
use ineluctable\models\EveCharacterWalletJournal;
use ineluctable\models\EveCharacterWalletTransactions;
use ineluctable\models\EveEveCharacterInfo;

use DB;
use ineluctable\models\EveInvGroups;
use ineluctable\repositories\CharacterContractsRepository;
use ineluctable\repositories\CharacterRepository;
use ineluctable\repositories\SkillQueueRepository;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //get data needed for the list of characters
        //name, corp, alliance - eve-characterinfo
        //sec status - eve-charcterinfo
        //skill points - eve-characterinfo
        //curret ship - eve-charcterinfo
        //current location - eve-charcterinfo
        //wallet balance - eve-charcterinfo
        //current skill training - skillintraining
        //skill queue length - skillqueue


        //first get list of characters associated with this user
        //$keys =  auth()->user()->ApiKeys()->get();

        //dd($keys[1]->characters()->get());


        //get the characters
        $characters = EveAccountAPIKeyInfoCharacters::MyCharacters();



        //get character info for each character - any way to avoid a db query for each?
        $characterlist = array();
        foreach($characters as $character)
        {
            $characterlist[] = $character->characterID;
        }

        $characterinfo = EveEveCharacterInfo::GetCharacterInfoIncludingSolarSystem($characterlist);
        $skillintraining = EveCharacterSkillInTraining::GetSkillinTraining($characterlist);
        $skillqueue = new SkillQueueRepository($characterlist);

        //$skillqueue = EveCharacterSkillQueue::GetSkillQueue( $characterlist );

    //build an array to make it easy for the view to work with!
        $characterarray = array();
        foreach ($characterinfo as $characterinfoitem)
        {
            $characterarray[$characterinfoitem->characterID] = array();
            $characterarray[$characterinfoitem->characterID]['info'] = $characterinfoitem;
            $characterarray[$characterinfoitem->characterID]['skillintraining'] = $skillintraining->where('characterID', $characterinfoitem->characterID)->first();
            $characterarray[$characterinfoitem->characterID]['skillqueue'] = $skillqueue->GetCharacterSkillQueue($characterinfoitem->characterID);

            //get the dotlan URL
            $characterarray[$characterinfoitem->characterID]['region'] = $characterinfoitem->solarsystem->getRegion();;
            $characterarray[$characterinfoitem->characterID]['dotlan'] = $characterinfoitem->solarsystem->getDotlanURL();

            //if in training then calculate and store extra info regarding the training
            if( isset($characterarray[$characterinfoitem->characterID]['skillintraining']) && ($characterarray[$characterinfoitem->characterID]['skillintraining']->skillInTraining==1))
            {

                $characterarray[$characterinfoitem->characterID]['currentskillpercentage'] = $characterarray[$characterinfoitem->characterID]['skillintraining']->getPercentComplete();
                $characterarray[$characterinfoitem->characterID]['currentskilltimetogo'] = $characterarray[$characterinfoitem->characterID]['skillintraining']->getTimeToGoAsTimestamp();

                //get last item in skill queue
                $characterarray[$characterinfoitem->characterID]['lastskilltrainEndDate'] = $skillqueue->GetEndDate($characterinfoitem->characterID);
                $characterarray[$characterinfoitem->characterID]['skillqueuepercentage'] = $skillqueue->GetPercentComplete($characterinfoitem->characterID);
                $characterarray[$characterinfoitem->characterID]['skillqueuetimetogo'] = $skillqueue->GetTimeToGo($characterinfoitem->characterID);


            }

        }

        //  dd($characterarray);

        return view('dashboard.characters.index')->with('characters',$characterarray);


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
    public function show($characterID)
    {
        ///return 'Show character with id:'.$id;

        $character = DB::table('account_apikeyinfo_characters')
            ->leftJoin('account_apikeyinfo', 'account_apikeyinfo_characters.keyID', '=', 'account_apikeyinfo.keyID')
            ->leftJoin('seat_keys', 'account_apikeyinfo_characters.keyID', '=', 'seat_keys.keyID')
            ->join('account_accountstatus', 'account_apikeyinfo_characters.keyID', '=', 'account_accountstatus.keyID')
            ->join('character_charactersheet', 'account_apikeyinfo_characters.characterID', '=', 'character_charactersheet.characterID')
            ->join('character_skillintraining', 'account_apikeyinfo_characters.characterID', '=', 'character_skillintraining.characterID')
            ->leftJoin('invTypes', 'character_skillintraining.trainingTypeID', '=', 'invTypes.typeID')
            ->where('character_charactersheet.characterID', $characterID)
            ->first();

        // Check if whave knowledge of this character, else, simply redirect to the
        // public character function
        if(count($character) <= 0)
            return  redirect()->action('CharacterController@getPublic', array('characterID' => $characterID))
                ->withErrors('No API key information is available for this character. This is the public view of the character. Submit a API key with this character on for more information.');

        // Next, check if the current user has access. Superusers may see all the things,
        // normal users may only see their own stuffs. SuperUser() inherits 'recruiter'
        if (!\Auth::hasAccess('recruiter'))
            if (!in_array(EveAccountAPIKeyInfoCharacters::where('characterID', $characterID)->value('keyID'), Session::get('valid_keys')))
                return redirect()->action('CharacterController@getPublic', array('characterID' => $characterID))
                    ->withErrors('You do not have access to view this character. This is the public view of the character.');

        // Determine the other characters that are on this API key
        $other_characters = DB::table('account_apikeyinfo_characters')
            ->join('character_charactersheet', 'account_apikeyinfo_characters.characterID', '=', 'character_charactersheet.characterID')
            ->join('character_skillintraining', 'account_apikeyinfo_characters.characterID', '=', 'character_skillintraining.characterID')
            ->where('account_apikeyinfo_characters.keyID', $character->keyID)
            ->where('account_apikeyinfo_characters.characterID', '<>', $character->characterID)
            ->get();

        // Get the other characters linked to this key as a person if any
        $key = $character->keyID;   // Small var declaration as I doubt you can use $character->keyID in the closure
        $people = DB::table('seat_people')
            ->leftJoin('account_apikeyinfo_characters', 'seat_people.keyID', '=', 'account_apikeyinfo_characters.keyID')
            ->whereIn('personID', function($query) use ($key) {

                $query->select('personID')
                    ->from('seat_people')
                    ->where('keyID', $key);
            })
            ->groupBy('characterID')
            ->get();

        //dd($other_characters);

        // Finally, give all this to the view to handle
        return view('dashboard.characters.show')
            ->with('character', $character)
            ->with('other_characters', $other_characters)
            ->with('people', $people);


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

    public function getPublic($characterID)
    {
        return 'display the public info for a the character: '.$characterID;
    }

    public function getAjaxCharacterSheet(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        $character = CharacterRepository::getApiKeyInfoCharacterPlusDetails($characterID);
        $character_info = CharacterRepository::getEveCharacterInfo($characterID);
        $employment_history = CharacterRepository::getEmploymentHistory($characterID);
        $skillpoints = CharacterRepository::getTotalSkillPoints($characterID);
        $skill_queue = CharacterRepository::getSkillQueue($characterID);
        $jump_clones = CharacterRepository::getJumpClones($characterID);
        $implants = CharacterRepository::getImplants($characterID);

       // Finally, give all this to the view to handle
        return view('dashboard.characters.ajax.character_sheet')
            ->with('character', $character)
            ->with('character_info', $character_info)
            ->with('employment_history', $employment_history)
            ->with('skillpoints', $skillpoints)
            ->with('skill_queue', $skill_queue)
            ->with('jump_clones', $jump_clones)
            ->with('implants', $implants);
    }

    public function getAjaxSkills(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        $skill_groups = EveInvGroups::SkillGroups()->get();

        // Now that we have all the groups, get the characters skills and info
        $character_skills_information = EveCharacterCharacterSheetSkills::GetSkillsWithTypeAndGroup($characterID);

        // Lastly, create an array that is easy to loop over in the template to display
        // the data
        $character_skills = array();
        foreach ($character_skills_information as $key => $value)
            $character_skills[$value->groupID][] =  array(
                'typeID' => $value->typeID,
                'groupName' => $value->groupName,
                'typeName' => $value->typeName,
                'description' => $value->description,
                'skillpoints' => $value->skillpoints,
                'level' => $value->level
            );

        // Finally, give all this to the view to handle
        return view('dashboard.characters.ajax.character_skills')
            ->with('skill_groups', $skill_groups)
            ->with('character_skills', $character_skills);
    }

    public function getAjaxWalletJournal(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Get the wallet journal
        $wallet_journal = EveCharacterWalletJournal::JournalIncludingRefTypes($characterID)->take(25)->get();


        //build the chart data

        //create the flt data as a json array
        $flotdata='[ ';
        $minyvalue = 999999999999999999;

        foreach($wallet_journal as $entry)
        {
            $flotdata .= '['. (($entry->date->timestamp)*1000).' , '. $entry->balance.' ], ';

            if($entry->balance < $minyvalue)
            {
                $minyvalue = $entry->balance;
            }
        }

        //trim off last , and add the ]
        $flotdata = rtrim($flotdata, ',').' ]';

        // Finally, give all this to the view to handle
        return view('dashboard.characters.ajax.wallet_journal', compact('wallet_journal', 'characterID', 'flotdata', 'minyvalue'));

    }

    public function getAjaxWalletTransactions(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Get the Wallet transactions
        $wallet_transactions = EveCharacterWalletTransactions::where('characterID', $characterID)
            ->orderBy('transactionDateTime', 'desc')
            ->take(25)
            ->get();

        // Finally, give all this to the view to handle
        return view('dashboard.characters.ajax.wallet_transactions')
            ->with('wallet_transactions', $wallet_transactions)
            ->with('characterID', $characterID);
    }

    public function getAjaxMail(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Get the Mail
        //list of unread messages
        $unreadcount = EveCharacterMailRecipients::GetMyUnreadMessagesCount(array($characterID));

        $mail = EveCharacterMailRecipients::where('characterID', $characterID)
            ->with('message')
            ->orderBy('messageID', 'desc')
            ->take(25)
            ->get();

        // Finally, give all this to the view to handle
        return view('dashboard.characters.ajax.mail')
            ->with('mail', $mail)
            ->with('characterID', $characterID);
    }

    public function getAjaxNotifications(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        $notifications = EveCharacterNotifications::where('characterID', $characterID)
                                    ->with('body', 'type')
                                    ->orderBy('sentDate', 'desc')
                                    ->take(25)
                                    ->get();


        // Finally, give all this to the view to handle
        return view('dashboard.characters.ajax.notifications')
            ->with('notifications', $notifications)
            ->with('characterID', $characterID);
    }

    public function getAjaxAssets(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        $locations = EveCharacterAssets::GetAssetLocationsForCharacter($characterID);

        return view('dashboard.characters.ajax.assets', compact('locations','characterID'));
    }

    public function getAjaxIndustry(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Get current working jobs
        $current_jobs = EveCharacterIndustryJobs::getCurrentJobsForACharacter($characterID);

        // Get the passed jobs
        $finished_jobs = EveCharacterIndustryJobs::getFinshedJobsForACharacter($characterID);

        // Return the view
        return view('dashboard.characters.ajax.industry', compact('characterID','current_jobs','finished_jobs'));

    }

    public function getAjaxContacts(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Get the contact list
        $contact_list = EveCharacterContactList::where('characterID', $characterID)
                            ->orderBy('standing', 'desc')
                            ->get();

        $corpcontacts = EveCharacterContactListCorporate::where('characterID', $characterID)
            ->orderBy('standing', 'desc')
            ->get();

        $alliancecontacts = EveCharacterContactListAlliance::where('characterID', $characterID)
            ->orderBy('standing', 'desc')
            ->get();

        return view('dashboard.characters.ajax.contacts', compact('contact_list', 'characterID', 'corpcontacts', 'alliancecontacts' ));

    }

    public function getAjaxContracts(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Create 2 array for seperate Courier and Other Contracts
        $contracts_courier = CharacterContractsRepository::GetCharacterCourierContracts($characterID);
        $contracts_other = CharacterContractsRepository::GetCharacterNonCourierContracts($characterID);

        //dd($contracts_other[0]->items[0]);
        return view('dashboard.characters.ajax.contracts', compact('contracts_courier', 'contracts_other', 'characterID' ));

    }

    public function getAjaxMarketOrders(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Get the market orders
        $market_orders = EveCharacterMarketOrders::ForCharacter($characterID)->get();

        $order_states = EveCharacterMarketOrders::getOrderStates();

        //dd($market_orders);

        return view('dashboard.characters.ajax.market_orders', compact('market_orders', 'order_states', 'characterID' ));

    }

    public function getAjaxCalendarEvents(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Character calendar events
        $calendar_events = EveCharacterUpcomingCalendarEvents::ForCharacter($characterID)->get();

        return view('dashboard.characters.ajax.calendar_events', compact('calendar_events', 'characterID' ));

    }

    public function getAjaxStandings(Request $request)
    {
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Standings
        $agent_standings = EveCharacterStandingsAgents::ForCharacter($characterID)->get();

        $faction_standings = EveCharacterStandingsFactions::ForCharacter($characterID)->get();

        $npc_standings = EveCharacterStandingsNPCCorporations::ForCharacter($characterID)->get();

        return view('dashboard.characters.ajax.character_standings', compact('agent_standings', 'faction_standings','npc_standings' , 'characterID' ));

    }

    public function getAjaxKillMails(Request $request)
    {
        // Check the character existance
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        $killmails = EveCharacterKillMails::ForCharacter($characterID)->get();

        return view('dashboard.characters.ajax.killmails', compact('killmails', 'characterID' ));

    }

    public function getAjaxResearchAgents(Request $request)
    {
        // Check the character existance
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        // Get the research agents
        $research = EveCharacterResearch::ForCharacter($characterID)->get();

        return view('dashboard.characters.ajax.character_research', compact('research', 'characterID' ));

    }

    public function getAjaxPlanetaryInteraction(Request $request)
    {
        // Check the character existance
        $characterID = $request->input('characterID');

        $this->CheckAccess($characterID);

        $routes = EveCharacterPlanetaryPins::RoutesForCharacter($characterID)->get();

        $links = EveCharacterPlanetaryPins::ForCharacter($characterID)->get();

        $installations = EveCharacterPlanetaryPins::InstallationsForCharacter($characterID)->get();

        $planets = EveCharacterPlanetaryColonies::ForCharacter($characterID)->get();

        // Prepare an empty array
        $colonies = array();

        // Populate the planet details
        foreach($planets as $planet)
            $colonies[$planet->planetID] = array(
                'planetID' => $planet->planetID,
                'planetName' => $planet->planetName,
                'planetTypeName' => $planet->planetTypeName,
                'upgradeLevel' => $planet->upgradeLevel,
                'numberOfPins' => $planet->numberOfPins
            );

        return view('dashboard.characters.ajax.character_pi', compact('colonies', 'routes', 'installations', 'links', 'characterID' ));

    }

    public function getFullWalletJournal()
    {
        return "TBD";
    }

    private function CheckAccess($characterID)
    {
        // Check the character existance
        $character = EveAccountAPIKeyInfoCharacters::where('characterID', $characterID)->first();

        // Check if whave knowledge of this character, else, 404
        if(count($character) <= 0)
            App::abort(404);

        // Next, check if the current user has access. Superusers may see all the things,
        // normal users may only see their own stuffs. . SuperUser() inherits 'recruiter'
        /*        if (!\Auth::hasAccess('recruiter'))
                    if (!in_array(EveAccountAPIKeyInfoCharacters::where('characterID', $characterID)->pluck('keyID'), Session::get('valid_keys')))
                        App::abort(404);*/
    }

}
