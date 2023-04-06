<?php

namespace App\Services\Reports;

use App\Jobs\ProcessReport;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Models\Report;

final class Service
{
    public function __construct(
        private readonly Repository $repository,
        private readonly Dispatcher $dispatcher,
    ) {}

    public function processNewReport(Query $query): Report
    {
        $report = $this->repository->create($query);
        $this->dispatcher->dispatch(new ProcessReport($report));

        return $report;
    }
}
