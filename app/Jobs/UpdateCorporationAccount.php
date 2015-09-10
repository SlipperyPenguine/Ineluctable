<?php

namespace ineluctable\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;

use ineluctable\EveApi\Corporation\AccountBalance;
use ineluctable\EveApi\Corporation\AssetList;
use ineluctable\EveApi\Corporation\ContactList;
use ineluctable\EveApi\Corporation\Contracts;
use ineluctable\EveApi\Corporation\CorporationSheet;
use ineluctable\EveApi\Corporation\CustomsOffices;
use ineluctable\EveApi\Corporation\IndustryJobs;
use ineluctable\EveApi\Corporation\KillMails;
use ineluctable\EveApi\Corporation\MarketOrders;
use ineluctable\EveApi\Corporation\Medals;
use ineluctable\EveApi\Corporation\MemberMedals;
use ineluctable\EveApi\Corporation\MemberSecurity;
use ineluctable\EveApi\Corporation\MemberSecurityLog;
use ineluctable\EveApi\Corporation\MemberTracking;
use ineluctable\EveApi\Corporation\Shareholders;
use ineluctable\EveApi\Corporation\Standings;
use ineluctable\EveApi\Corporation\StarbaseDetail;
use ineluctable\EveApi\Corporation\StarbaseList;
use ineluctable\EveApi\Corporation\Titles;
use ineluctable\EveApi\Corporation\WalletJournal;
use ineluctable\EveApi\Corporation\WalletTransactions;

class UpdateCorporationAccount extends Job implements SelfHandling
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
            ContactList::Update($this->keyid, $this->vcode);
            Contracts::Update($this->keyid, $this->vcode);
            CorporationSheet::Update($this->keyid, $this->vcode);
            CustomsOffices::Update($this->keyid, $this->vcode);
            IndustryJobs::Update($this->keyid, $this->vcode);
            KillMails::Update($this->keyid, $this->vcode);
            MarketOrders::Update($this->keyid, $this->vcode);
            Medals::Update($this->keyid, $this->vcode);
            MemberMedals::Update($this->keyid, $this->vcode);
            MemberSecurity::Update($this->keyid, $this->vcode);
            MemberSecurityLog::Update($this->keyid, $this->vcode);
            MemberTracking::Update($this->keyid, $this->vcode);
            Shareholders::Update($this->keyid, $this->vcode);
            Standings::Update($this->keyid, $this->vcode);
            StarbaseList::Update($this->keyid, $this->vcode);
            StarbaseDetail::Update($this->keyid, $this->vcode);
            Titles::Update($this->keyid, $this->vcode);
            WalletJournal::Update($this->keyid, $this->vcode);
            WalletTransactions::Update($this->keyid, $this->vcode);

        }
        catch (\Exception $e)
        {
            \Log::critical($e->getCode() . ':' . $e->getMessage());
        }
    }
}
