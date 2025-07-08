<?php

namespace App\Notifications\Whatsapp;

use App\Core\Bus\AbstractNotification;
use App\Enums\StatusType;
use App\Models\Financing\Disbursement;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Fluent;

class SendDisbursmentStatus extends AbstractNotification
{
    protected $disbursement;

    /**
     * Create a new notification instance.
     *
     * @param  App\Models\User  $userId
     * @param  App\Models\Financing\Disbursement  $disbursement
     */
    public function __construct(User $userId, Disbursement $disbursement)
    {
        parent::__construct($userId);

        // $this->queue = 'priority';
        $this->disbursement = $disbursement;
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
            tags: ['financing', 'disbursement']
        );

        return $wa->send(
            key: 'reminder.disbursement',
            content: $msg,
            sender: config('msnotif.driver.woowa.sender'),
            recipient: $user->phone ?? ''
        );
    }

    private function getMessage(Fluent $user): string
    {
        $disbursement = $this->disbursement;

        $plafonAmount = $disbursement->plafon->plafon_amount ? 'Rp ' . number_format($disbursement->plafon->plafon_amount) : '';
        $disbursementAmount = $disbursement->disbursement_amount ? 'Rp ' . number_format($disbursement->disbursement_amount) : '';
        $numberLobc = $disbursement->additional['number_lobc'] ?? '';
        $ticket_settlement_date = $disbursement->additional['ticket_settlement_date'] ? \Carbon\Carbon::parse($disbursement->additional['ticket_settlement_date'])->format('Y-m-d') : '';
        $lcu = $disbursement->lcu ?? '';
        $isDoneTransfer = $disbursement->is_done_transfer_to_airline == true ? 'DONE' : 'NOT DONE';
        $status = $disbursement->status ?  StatusType::from($disbursement->status->value)->label()  : '';

        return "Pengajuan Pencairan Pembiayaan\n\n" .
            "• Nama Travel : {$disbursement->travel->name}\n" .
            "• Plafon Pembiayaan : Rp {$plafonAmount}\n" .
            "• Nominal Pencairan : Rp {$disbursementAmount}\n" .
            "• Nomor LOBC : {$numberLobc}\n" .
            "• Tgl Pelunasan Tiket : {$ticket_settlement_date}\n" .
            "• LCU : {$lcu}\n" .
            "• Pemindahan buku ke Maskapai : {$isDoneTransfer}\n" .
            "• Status : {$status}\n";
    }
}
