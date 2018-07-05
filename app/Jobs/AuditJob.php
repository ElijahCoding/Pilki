<?php

namespace App\Jobs;

use App\Models\Audit;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AuditJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event;
    public $modelType;
    public $modelId;
    public $userType;
    public $userId;
    public $changes;
    public $ip;

    /**
     * Create a new job instance.
     *
     * @param $event
     * @param $modelType
     * @param $modelId
     * @param $userType
     * @param $userId
     * @param $changes
     * @param $ip
     */
    public function __construct($event, $modelType, $modelId, $userType, $userId, $changes, $ip)
    {
        $this->onQueue('audit');

        $this->event = $event;
        $this->modelType = $modelType;
        $this->modelId = $modelId;
        $this->userType = $userType;
        $this->userId = $userId;
        $this->changes = $changes;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Audit::create([
            'event'      => $this->event,
            'user_type'  => $this->userType,
            'user_id'    => $this->userId,
            'model_type' => $this->modelType,
            'model_id'   => $this->modelId,
            'changes'    => $this->changes,
            'ip'         => $this->ip,
        ]);
    }
}
