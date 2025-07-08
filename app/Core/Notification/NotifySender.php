<?php

namespace App\Core\Notification;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifySender implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var array */
    public array $body = [];

    /** @var NotifySendAction|null */
    protected NotifySendAction|null $action = null;

    /**
     * Create a new job instance.
     *
     * @param  string  $processId
     * @param  array  $tags
     */
    public function __construct(
        private readonly string $processId,
        private readonly array $tags = []
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->action = new NotifySendAction(
            $this->processId,
            $this->tags
        );
        $this->action->sendIt();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     *
     * @return void
     * @throws \Throwable
     */
    public function failed(Exception $exception): void
    {
        // Send user notification of failure, etc...
        NotificationLog::updateLog($this->processId, 'failed job send notif', [], $exception);
    }
}
