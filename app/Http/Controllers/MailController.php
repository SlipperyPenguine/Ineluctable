<?php

namespace ineluctable\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use ineluctable\Events\MailMessageDisplayed;
use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;
use ineluctable\models\EveAccountAPIKeyInfoCharacters;
use ineluctable\models\EveCharacterMailingLists;
use ineluctable\models\EveCharacterMailMessages;
use ineluctable\models\EveCharacterMailRecipients;
use ineluctable\models\EveCorporations;
use ineluctable\models\EveEveAllianceList;
use ineluctable\models\EveEveCharacterInfo;
use Pusher;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //list all the mail messages
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        //list of unread messages
        $unreadcount = EveCharacterMailRecipients::GetMyUnreadMessagesCount($characterlist);

        $mail = EveCharacterMailRecipients::whereIn('characterID', $characterlist)
            ->where('trash', false)
            ->groupBy('messageID')
            ->with('message')
            ->orderBy('messageID', 'desc')
            ->get();

        return view('dashboard.mail.index', compact('unreadcount', 'mail'));

    }

    public function getUnreadMail()
    {
        //list all the mail messages
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        //list of unread messages
        $unreadcount = EveCharacterMailRecipients::GetMyUnreadMessagesCount($characterlist);

        $mail = EveCharacterMailRecipients::whereIn('characterID', $characterlist)
            ->where('read', false)
            ->groupBy('messageID')
            ->with('message')
            ->orderBy('messageID', 'desc')
            ->get();

        $title = 'Unread Mail Messages';

        return view('dashboard.mail.index', compact('unreadcount', 'mail', 'title'));

    }

    public function getImportantMail()
    {
        //list all the mail messages
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        //list of unread messages
        $unreadcount = EveCharacterMailRecipients::GetMyUnreadMessagesCount($characterlist);

        $mail = EveCharacterMailRecipients::whereIn('characterID', $characterlist)
            ->where('important', true)
            ->groupBy('messageID')
            ->with('message')
            ->orderBy('messageID', 'desc')
            ->get();

        $title = 'Important Mail Messages';

        return view('dashboard.mail.index', compact('unreadcount', 'mail', 'title'));

    }

    public function getTrashMail()
    {
        //list all the mail messages
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        //list of unread messages
        $unreadcount = EveCharacterMailRecipients::GetMyUnreadMessagesCount($characterlist);

        $mail = EveCharacterMailRecipients::whereIn('characterID', $characterlist)
            ->where('trash', true)
            ->groupBy('messageID')
            ->with('message')
            ->orderBy('messageID', 'desc')
            ->get();

        $title = 'Trashed Mail Messages';

        return view('dashboard.mail.index', compact('unreadcount', 'mail', 'title'));

    }
    public function MailForCharacter($characterID)
    {

        //list of unread messages
        $unreadcount = EveCharacterMailRecipients::GetMyUnreadMessagesCount(array($characterID));

        $mail = EveCharacterMailRecipients::where('characterID', $characterID)
            ->with('message')
            ->orderBy('messageID', 'desc')
            ->get();


        $selectedcharacter = EveAccountAPIKeyInfoCharacters::where('characterID',$characterID )->first()->characterName;

        return view('dashboard.mail.index', compact('unreadcount', 'mail', 'selectedcharacter'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //not sure we an create mail
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //can't create new ones
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $message = EveCharacterMailMessages::where('messageID', $id)
                            ->with('body', 'recipients')
                            ->firstOrFail();

        return view('dashboard.mail.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //maybe edit to move it or set it as read!
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
        //record it's read
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //some form of soft delete maybe
    }

    public function MarkMailAsRead(Request $request)
    {
        $selectedmails = explode(',', $request->input("selectedmails"));
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        $mail = EveCharacterMailRecipients::whereIn('characterID', $characterlist)
            ->whereIn('messageID', $selectedmails)
            ->update(['read' => true]);

        flash()->success('Success', 'Mails marked as read');
        return redirect('dashboard/mail');
    }

    public function MarkMailAsImportant(Request $request)
    {
        $selectedmails = explode(',', $request->input("selectedmails"));
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        $mail = EveCharacterMailRecipients::whereIn('characterID', $characterlist)
            ->whereIn('messageID', $selectedmails)
            ->update(['important' => true]);

        flash()->success('Success', 'Mails marked as important');
        return redirect('dashboard/mail');
    }

    public function MoveMailToTrash(Request $request)
    {
        $selectedmails = explode(',', $request->input("selectedmails"));
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        $mail = EveCharacterMailRecipients::whereIn('characterID', $characterlist)
            ->whereIn('messageID', $selectedmails)
            ->update(['trash' => true]);

        flash()->success('Success', 'Mails moved to trash');
        return redirect('dashboard/mail');
    }


    public function MarkAllMailAsRead()
    {
        $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();

        $mail = EveCharacterMailRecipients::whereIn('characterID', $characterlist)
            ->update(['read' => true]);

        flash()->success('Success', 'ALL Mails marked as read');
        return redirect('dashboard/mail');
    }


    public function getAjaxRecipients(Request $request)
    {
        $toCorpOrAllianceID = $request->input('toCorpOrAllianceID');
        $toListID = $request->input('toListID');
        $toCharacterIDs = $request->input('toCharacterIDs');

        //for now just build a string, will use a view
        //$output = '<ul> ';
        $alliances = array();
        $corportations = array();
        $characters = array();
        $mailinglists = array();

        if($toCorpOrAllianceID!='')
        {
            $corpsandalliances = explode(',', $toCorpOrAllianceID);
            foreach($corpsandalliances as $corporalliance)
            {
                //first check if in alliances list
                $alliance = EveEveAllianceList::where('allianceID', $corporalliance)->first();

                if ($alliance)
                {
                    $alliances[] = $alliance;
                }
                else
                {
                    $corp = EveCorporations::getCorp($corporalliance);
                    $corportations[] = $corp;
                }


            }
        }

        if($toCharacterIDs!='')
        {
            $characterIDs = explode(',', $toCharacterIDs);
            foreach($characterIDs as $characterID)
            {
                $charid = intval($characterID);
                $character = EveEveCharacterInfo::getCharacter($charid);
                $characters[] = $character;
            }
        }

        if($toListID!='')
        {
            $listIDs = explode(',', $toListID);
            foreach($listIDs as $listID) {
                $list = EveCharacterMailingLists::where('listID', $listID)->first();
                if ($list) {
                    $mailinglists[] = $list->displayName;
                }
                else
                {
                    $mailinglists[] = "Unknown mailing list";
                }

            }
        }
        //var_dump($request);
        return view('dashboard.mail.ajax.recipients', compact('alliances', 'corportations', 'characters', 'mailinglists'));
    }
}
