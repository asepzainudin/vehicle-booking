<?php

namespace App\Console\Commands;

use App\Enums\StatusType;
use App\Models\Financing\Disbursement;
use App\Notifications\ReminderRequest;
use App\Notifications\Whatsapp\SendReminderSettlement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendEmailReminderSettlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-reminder-settlement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $disbursements = Disbursement::query()
            ->where('status', StatusType::APPROVED)
            ->whereHas('plafon', function ($qry) {
                $qry->whereColumn('plafon_remaining', '<', 'plafon_amount');
            })
            ->whereDate('additional->ticket_settlement_date', '>=', now())
            ->whereDate('additional->ticket_settlement_date', '<=', now()->addDays(5))
            ->get();

        if ($disbursements->count() < 0) {
            $emails = [];

            foreach ($disbursements as $disbursement) {
                // Cek apakah sudah dikirim hari ini
                if ($disbursement->last_reminder_sent_at === $today) {
                    continue;
                }

                $emails[] = $disbursement->plafon->rm->email;
                $emails[] = $disbursement->plafon->specialist->email;
                $emails[] = $disbursement->plafon->picpihk->email;

                foreach ($emails as $key => $value) {
                    if (!empty($value)) {
                        // Kirim email ke user
                        Notification::route('mail', $value)
                            ->notify(new ReminderRequest($disbursement));
                    }
                }

                if ($disbursement->plafon->rm) {
                    dispatch(new SendReminderSettlement($disbursement->plafon->rm, $disbursement));
                }

                if ($disbursement->plafon->picpihk) {
                    dispatch(new SendReminderSettlement($disbursement->plafon->picpihk, $disbursement));
                }

                // Update tanggal pengiriman notifikasi
                $disbursement->last_reminder_sent_at = $today;
                $disbursement->save();
            }
        }

        $this->info('Reminder Settlement sent successfully.');
    }
}
