<?php

namespace App\Notifications\Whatsapp;

use App\Core\Bus\AbstractNotification;
use App\Models\Financing\Disbursement;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Fluent;

class SendReminderSettlement extends AbstractNotification
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
            tags: ['reminder', 'settlement']
        );
        return $wa->send(
            key: 'reminder.settlement',
            content: $msg,
            // sender: $user->wa_key ?? '',
            sender: config('msnotif.driver.woowa.sender'),
            recipient: $user->phone ?? ''
        );
    }

    private function getMessage(Fluent $user): string
    {
        $disbursement = $this->disbursement;
        $remaining = number_format($disbursement->plafon->plafon_remaining);
        $ticket_settlement_date = $disbursement->additional['ticket_settlement_date'] ? \Carbon\Carbon::parse($disbursement->additional['ticket_settlement_date'])->format('Y-m-d') : '';

        return "Assalamu’alaikum Warahmatullahi Wabarakatuh,\n\n" .
            "Melalui email ini, kami informasikan bahwa jatuh tempo pelunasan pembiayaan.\n" .
            "Berikut detail informasi pembiayaan:\n" .
            "• Nama Travel : {$disbursement->travel->name}\n" .
            "• Nomor OL : {$disbursement->plafon->ol_number}\n" .
            "• Jumlah yang Harus Dilunasi : Rp {$remaining}\n" .
            "• Tanggal Jatuh Tempo : {$ticket_settlement_date}\n" .
            "Kami menyarankan untuk segera melakukan pelunasan sebelum tanggal jatuh tempo guna menghindari biaya tambahan atau konsekuensi lainnya.\n\n" .
            "Apabila pelunasan telah dilakukan, abaikan pemberitahuan ini.\n\n" .
            "Terima kasih atas perhatian Anda.\n\n" .
            "Hormat kami,\n" .
            "Tim Pembiayaan";
    }
}
