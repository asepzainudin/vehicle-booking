<?php

namespace App\Notifications\Whatsapp;

use App\Core\Bus\AbstractNotification;
use App\Enums\StatusType;
use App\Models\Financing\Repayment;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Fluent;

class SendRepaymentStatus extends AbstractNotification
{
    protected $repayment;

    /**
     * Create a new notification instance.
     *
     * @param  App\Models\User  $userId
     * @param  App\Models\Financing\Repayment  $repayment
     */
    public function __construct(User $userId, Repayment $repayment)
    {
        parent::__construct($userId);

        // $this->queue = 'priority';
        $this->repayment = $repayment;
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
            tags: ['financing', 'repayment']
        );

        return $wa->send(
            key: 'reminder.repayment',
            content: $msg,
            sender: config('msnotif.driver.woowa.sender'),
            recipient: $user->phone ?? ''
        );
    }

    private function getMessage(Fluent $user): string
    {
        $repayment = $this->repayment;

        $plafonAmount = $repayment->plafon->plafon_amount ? 'Rp ' . number_format($repayment->plafon->plafon_amount) : '';
        $repaymentAmount =  $repayment->repayment_amount ? 'Rp ' . number_format($repayment->repayment_amount) : '';
        $numberLobc = $plafon->additional['number_lobc'] ?? '';
        $lcu = $repayment->lcu ? $repayment->lcu : '';
        $status = $repayment->status ? StatusType::from($repayment->status->value)->label()  : '';

        return "Pelunasan Pembiayaan\n" .
            "• Nama Travel : {$repayment->travel->name}\n" .
            "• Plafon Pembiayaan : Rp {$plafonAmount}\n" .
            "• Nominal Pelunasan : Rp {$repaymentAmount}\n" .
            "• Nomor LOBC : {$numberLobc}\n" .
            "• LCU : {$lcu}\n" .
            "• Status : {$status}\n";
    }
}
