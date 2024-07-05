<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\UpdateTotalChat;
use App\Services\ChatService;

class TotalChatNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $chatService;
    public $total;
    public $companyId;

    /**
     * Create a new job instance.
     */
    public function __construct($companyId)
    {
     
        $this->companyId = $companyId;
        $this->chatService = app(ChatService::class);
        $totalStatus = $this->chatService->totalStatus($this->companyId);
        $this->total = $totalStatus['total'];
   
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        UpdateTotalChat::dispatch($this->total, $this->companyId);
    }
}
