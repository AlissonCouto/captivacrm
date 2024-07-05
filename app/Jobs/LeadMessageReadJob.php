<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\LeadMessageRead;

class LeadMessageReadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sid;
    public $html;
    public $companyId;

    /**
     * Create a new job instance.
     */
    public function __construct($sid, $html, int $companyId)
    {
        $this->sid = $sid;
        $this->html = $html;
        $this->companyId = $companyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        LeadMessageRead::dispatch($this->sid, $this->html, $this->companyId);
    }
}
