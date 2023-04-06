<?php

namespace App\Services\Reports;

use App\Models\Report;
use App\Services\Reports\ReportGenerators\ReportGenerator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;

final class Processor
{
    public function __construct(
        private readonly Repository $reportRepository,
        private readonly Filesystem $storage,
        private readonly ReportGenerator $reportGenerator,
    ){}

    public function process(Report $report): void
    {
        $path = uniqid("{$report->id}_") . '.csv';

        $report->path = $path;
        $report->status = StatusEnum::PROCESSING;
        $this->reportRepository->update($report);

        try {
            $stream = $this->reportGenerator->generate(Query::createFromArray($report->query));
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage() . PHP_EOL . PHP_EOL . $exception->getTraceAsString());
            $report->status = StatusEnum::FAILED;
            $this->reportRepository->update($report);
            return;
        }

        $this->storage->put($path, $stream);

        $report->status = StatusEnum::READY;
        $this->reportRepository->update($report);
    }
}
