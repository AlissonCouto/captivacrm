<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\MessageReceived;
use App\Models\Lead;

class ReceiveMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;
    public $companyId;
    public $html;

    /**
     * Create a new job instance.
     */
    public function __construct($message, $companyId, $html)
    {
        $this->message = $message;
        $this->companyId = $companyId;
        $this->html = $html;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        MessageReceived::dispatch($this->message, $this->companyId, $this->html);
    }
}
