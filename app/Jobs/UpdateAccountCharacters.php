<?php

namespace ineluctable\Jobs;

use ineluctable\EveApi\Character\AccountBalance;
use ineluctable\EveApi\Character\AssetList;
use ineluctable\EveApi\Character\CharacterSheet;
use ineluctable\EveApi\Character\ContactList;
use ineluctable\EveApi\Character\ContactNotifications;
use ineluctable\EveApi\Character\Contracts;
use ineluctable\EveApi\Character\IndustryJobs;
use ineluctable\EveApi\Character\Info;
use ineluctable\EveApi\Character\KillMails;
use ineluctable\EveApi\Character\MailingLists;
use ineluctable\EveApi\Character\MailMessages;
use ineluctable\EveApi\Character\MarketOrders;
use ineluctable\EveApi\Character\Notifications;
use ineluctable\EveApi\Character\PlanetaryColonies;
use ineluctable\EveApi\Character\Research;
use ineluctable\EveApi\Character\SkillInTraining;
use ineluctable\EveApi\Character\SkillQueue;
use ineluctable\EveApi\Character\Standings;
use ineluctable\EveApi\Character\UpcomingCalendarEvents;
use ineluctable\EveApi\Character\WalletJournal;
use ineluctable\EveApi\Character\WalletTransactions;
use ineluctable\EveApi\Character\Bookmarks;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateAccountCharacters extends Job implements SelfHandling
{
    use InteractsWithQueue, SerializesModels;

    private $keyid;
    private $vcode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($keyid, $vcode)
    {
        $this->keyid = $keyid;
        $this->vcode = $vcode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try
        {
            AccountBalance::Update($this->keyid, $this->vcode);
            AssetList::Update($this->keyid, $this->vcode);
            CharacterSheet::Update($this->keyid, $this->vcode);
            ContactList::Update($this->keyid, $this->vcode);
            ContactNotifications::Update($this->keyid, $this->vcode);
            Contracts::Update($this->keyid, $this->vcode);
            IndustryJobs::Update($this->keyid, $this->vcode);
            Info::Update($this->keyid, $this->vcode);
            KillMails::Update($this->keyid, $this->vcode);
            MailMessages::Update($this->keyid, $this->vcode);
            MailingLists::Update($this->keyid, $this->vcode);
            Notifications::Update($this->keyid, $this->vcode);
            PlanetaryColonies::Update($this->keyid, $this->vcode);
            MarketOrders::Update($this->keyid, $this->vcode);
            Research::Update($this->keyid, $this->vcode);
            SkillInTraining::Update($this->keyid, $this->vcode);
            SkillQueue::Update($this->keyid, $this->vcode);
            Standings::Update($this->keyid, $this->vcode);
            UpcomingCalendarEvents::Update($this->keyid, $this->vcode);
            WalletJournal::Update($this->keyid, $this->vcode);
            WalletTransactions::Update($this->keyid, $this->vcode);
            Bookmarks::Update($this->keyid, $this->vcode);

        }
        catch (\Exception $e)
        {
            \Log::critical($e->getCode() . ':' . $e->getMessage());
        }
    }
}
