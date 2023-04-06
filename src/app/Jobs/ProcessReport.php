<?php

namespace App\Jobs;

use App\Models\Report;
use App\Services\Reports;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessReport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Report $report,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(Reports\Processor $processor): void
    {
        Log::info("Report generation started #{$this->report->id}");

        $beforeTime = time();
        $processor->process($this->report);

        Log::info("Report generation finished #{$this->report->id}, took time(sec): " . time() - $beforeTime);
    }
}
