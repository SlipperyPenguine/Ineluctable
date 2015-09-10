<?php

namespace ineluctable\Providers;

use Illuminate\Support\ServiceProvider;
use ineluctable\models\EveAccountAPIKeyInfoCharacters;
use ineluctable\models\EveCharacterMailRecipients;
use ineluctable\models\SeatUserSetting;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->AddVariablesForDashboardNavbar();
        $this->AddServerStatusToFooter();
        $this->AddCharactersToTopBar();
        $this->AddCorporationsToTopBar();
        $this->AddUnreadMailsToMenus();

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    private function AddServerStatusToFooter()
    {
        view()->composer('dashboard.partials.footer', function($view)
        {
            $serverstatus = \ineluctable\models\EveServerServerStatus::get()->first();
            $view->with(compact('serverstatus'));
        });

    }

    private function AddVariablesForDashboardNavbar()
    {

        view()->composer('dashboard.partials.navbar', function($view)
        {

/*            $CharacterID = SeatUserSetting::where('user_id', auth()->user()->id )
                ->where('setting','main_character_id')
                ->first()->value;*/

            $action = app('request')->route()->getAction();

            $controller = class_basename($action['controller']);

            list($controller, $action) = explode('@', $controller);

            $view->with(compact('controller', 'action'));
        });
    }

    private function AddCharactersToTopBar()
    {
        view()->composer(['dashboard.partials.topbar','dashboard.mail.index'], function($view)
        {

            //$characters = \ineluctable\models\EveAccountAPIKeyInfoCharacters::all();
            $characters = EveAccountAPIKeyInfoCharacters::MyCharacters();

            $view->with(compact('characters'));
        });
    }

    private function AddCorporationsToTopBar()
    {
        view()->composer('dashboard.partials.topbar', function($view)
        {

            //$characters = \ineluctable\models\EveAccountAPIKeyInfoCharacters::all();
            $corporations = EveAccountAPIKeyInfoCharacters::MyCorporations();
            $view->with(compact('corporations'));
        });
    }

    private function AddUnreadMailsToMenus()
    {
        view()->composer(['dashboard.partials.navbar','dashboard.partials.topbar'], function($view)
        {

            $characterlist  = EveAccountAPIKeyInfoCharacters::MyCharactersAsArray();
            $recentmails = null;
            $unreadmails = null;
            if(count($characterlist)>0) {
                $unreadmails = EveCharacterMailRecipients::GetMyUnreadMessagesCount($characterlist);
                if ($unreadmails > 0) {
                    $recentmails = EveCharacterMailRecipients::MyUnreadMessages()
                        ->groupBy('messageID')
                        ->with('message')
                        ->orderBy('messageID', 'desc')
                        ->take(3)
                        ->get();
                } else {
                    $recentmails = EveCharacterMailRecipients::groupBy('messageID')
                        ->with('message')
                        ->orderBy('messageID', 'desc')
                        ->take(3)
                        ->get();
                }
            }
            $view->with(compact('unreadmails', 'recentmails'));
        });
    }
}
