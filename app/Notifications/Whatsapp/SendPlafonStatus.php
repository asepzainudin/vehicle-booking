<?php

namespace App\Notifications\Whatsapp;

use App\Core\Bus\AbstractNotification;
use App\Models\Financing\Plafon;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Fluent;

class SendPlafonStatus extends AbstractNotification
{
    protected $plafon;

    /**
     * Create a new notification instance.
     *
     * @param  App\Models\User  $userId
     * @param  App\Models\Financing\Plafon  $plafon
     */
    public function __construct(User $userId, Plafon $plafon)
    {
        parent::__construct($userId);

        // $this->queue = 'priority';
        $this->plafon = $plafon;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Throwable
     */
    public function handle()
    {
        // Begin Queue Notifications
        $this->toWa();
    }

    /**
     * notify to whatsApp.
     *
     * @return bool
     * @throws \Throwable
     */
    public function toWa(): bool
    {
        $user = $this->userData();

        $msg = $this->getMessage($user);

        $wa = msnotif(
            channel: $user->wa_channel ?? '',
            partnerId: null,
            tags: ['financing', 'plafon']
        );

        return $wa->send(
            key: 'reminder.plafon',
            content: $msg,
            sender: config('msnotif.driver.woowa.sender'),
            recipient: $user->phone ?? ''
        );
    }

    private function getMessage(Fluent $user): string
    {
        $plafon = $this->plafon;

        $plafonAmount = $plafon->plafon_amount ? 'Rp ' . number_format($plafon->plafon_amount) : '';
        $pull_relief = $plafon->additional['pull_relief'] ? 'Rp ' . number_format($plafon->additional['pull_relief']) : '';
        $flagging = $plafon->additional['flagging_revolving'] ?? '';
        $nameRm = $plafon->rm ? $plafon->rm->name : '';
        $email_rm = $plafon->rm ? $plafon->rm->email : '';
        $specialist = $plafon->specialist ? $plafon->specialist->name : '';
        $pic_pihk = $plafon->picpihk ? $plafon->picpihk->name : '';

        return "Plafon Pembiayaann\n" .
            "• Nama Travel : {$plafon->travel->name}\n" .
            "• Nomor OL : {$plafon->ol_number}\n" .
            "• Plafon Pembiayaan : Rp {$plafonAmount}\n" .
            "• Kelonggaran Tarik : Rp {$pull_relief}\n" .
            "• Flagging Revolving : {$flagging}\n" .
            "• Nama RM : {$nameRm}\n" .
            "• Email RM : {$email_rm}\n" .
            "• Email Spesialist : {$specialist}\n" .
            "• Email PIK PIHK : {$pic_pihk}\n";
    }
}
