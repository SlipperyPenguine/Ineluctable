<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('test', function(){return 'done';});

Route::get('home', 'pagescontroller@home');
Route::get('indevelopment', 'pagescontroller@indevelopment');
Route::get('jumpfatigue', 'pagescontroller@jumpfatigue');
Route::get('entosis', 'pagescontroller@entosis');
Route::get('/', 'pagescontroller@home');


Route::get('api/updatecharacters', 'apicontroller@UpdateCharacters');

Route::controllers(['auth'=>'Auth\AuthController', 'password'=>'Auth\PasswordController']);

Route::controller('helpers', 'HelperController');
Route::get('accounts.json', 'HelperController@getAccounts');

/*Route::get('login', 'authcontroller@login');
Route::get('logout', 'authcontroller@logout');
Route::get('logincallback', 'authcontroller@handleProviderCallback');*/


Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

    Route::post('apikeys/TransferOwnership', 'ApiKeyController@TransferOwnership');

    Route::get('mail/markasread', 'MailController@MarkMailAsRead');
    Route::get('mail/marksllasread', 'MailController@MarkAllMailAsRead');
    Route::get('mail/markasimportant', 'MailController@MarkMailAsImportant');
    Route::get('mail/movetotrash', 'MailController@MoveMailToTrash');
    Route::get('mail/forcharacter/{characterID}', 'MailController@MailForCharacter');

    Route::get('mail/getUnreadMail', 'MailController@getUnreadMail');
    Route::get('mail/getImportantMail', 'MailController@getImportantMail');
    Route::get('mail/getTrashMail', 'MailController@getTrashMail');


    Route::get('mail/getAjaxRecipients', array('as' => 'mail.getAjaxRecipients', 'uses' => 'MailController@getAjaxRecipients'));

    Route::get('assets/searchassets', array('as' => 'assets.SearchAllAssets', 'uses' => 'AssetController@SearchAllAssets'));
    Route::post('assets/searchassets', array('as' => 'assets.PostSearchAllAssets', 'uses' => 'AssetController@PostSearchAllAssets'));
    Route::post('assets/searchcharacterassets', array('as' => 'assets.PostSearchCharacterAssets', 'uses' => 'AssetController@PostSearchCharacterAssets'));
    Route::get('assets/ajaxitemsearch',  'AssetController@AjaxItemSearch');
    Route::get('assets/AjaxGetLocationAssets/{locationID}',  'AssetController@AjaxGetLocationAssets');
    Route::get('assets/AjaxGetAssetsContents/{locationID}',  'AssetController@AjaxGetAssetsContents');
    Route::get('character/{characterID}/assets/AjaxGetLocationAssets/{locationID}',  'AssetController@AjaxGetCharacterLocationAssets');


    Route::resource('apikeys', 'ApiKeyController');
    Route::resource('mail', 'MailController');
    Route::resource('apikeys.characters', 'ApiKeyCharacterController');

    route::get('characters/getAjaxCharacterSheet', 'CharacterController@getAjaxCharacterSheet');
    route::get('characters/getAjaxSkills', 'CharacterController@getAjaxSkills');
    route::get('characters/getAjaxWalletJournal', 'CharacterController@getAjaxWalletJournal');
    route::get('characters/getAjaxWalletTransactions', 'CharacterController@getAjaxWalletTransactions');
    route::get('characters/getAjaxMail', 'CharacterController@getAjaxMail');
    route::get('characters/getAjaxNotifications', 'CharacterController@getAjaxNotifications');
    route::get('characters/getAjaxAssets', 'CharacterController@getAjaxAssets');
    route::get('characters/getAjaxIndustry', 'CharacterController@getAjaxIndustry');
    route::get('characters/getAjaxContacts', 'CharacterController@getAjaxContacts');
    route::get('characters/getAjaxContracts', 'CharacterController@getAjaxContracts');
    route::get('characters/getAjaxMarketOrders', 'CharacterController@getAjaxMarketOrders');
    route::get('characters/getAjaxCalendarEvents', 'CharacterController@getAjaxCalendarEvents');
    route::get('characters/getAjaxStandings', 'CharacterController@getAjaxStandings');
    route::get('characters/getAjaxKillMails', 'CharacterController@getAjaxKillMails');
    route::get('characters/getAjaxResearchAgents', 'CharacterController@getAjaxResearchAgents');
    route::get('characters/getAjaxPlanetaryInteraction', 'CharacterController@getAjaxPlanetaryInteraction');

    route::get('characters/getFullWalletJournal', 'CharacterController@getFullWalletJournal');

    //getFullWalletJournal

    route::get('characters/{characterID}/getPublic', 'CharacterController@getPublic');
    Route::resource('characters', 'CharacterController');


    Route::get('users/impersonate', 'UserController@Impersonate');
    Route::get('users/DeleteAUser', 'UserController@DeleteAUser');
    Route::resource('users', 'UserController');



    Route::get('apikeys/{apikey}/characters/{character}/skillintraining', 'ApiKeyCharacterController@skillintraining');


    Route::get('debug/api', 'DebugController@getApi');
    Route::get('debug/browser', 'DebugController@browser');
    Route::get('debug/logfiles', 'DebugController@logfiles');
    Route::get('debug/jobs', 'DebugController@jobs');
    Route::post('debug/deletelaravellog', 'DebugController@deletelaravellog');
    Route::post('debug/deletephealaccesslog', 'DebugController@deletephealaccesslog');
    Route::post('debug/deletephealerrorlog', 'DebugController@deletephealerrorlog');

    Route::post('debugpostquery', 'DebugController@postQuery');
    Route::post('debugAjaxGetCallList', 'DebugController@AjaxGetCallList');

    Route::post('apikeyajaxcheckkey', 'ApiKeyController@ajaxcheckkey');


    Route::get('home', 'DashboardController@home');
    Route::get('profile', 'ProfileController@showProfile');
    Route::get('profilegetaccesslog', 'ProfileController@getAccessLog');
    Route::post('profile', 'ProfileController@postProfile');
    Route::post('profilechangepassword', 'ProfileController@postChangePassword');

    Route::get('debug/api', 'DebugController@DashboardGetApi');

});









