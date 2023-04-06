<?php

namespace Tests\Unit;

use App\Models\Report;
use App\Services\Reports\Query;
use App\Services\Reports\Repository;
use App\Services\Reports\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testSuccessFlow(): void
    {
        $repository = $this->createMock(Repository::class);
        $repository->expects($this->once())->method('create');

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())->method('dispatch');

        $service = new Service($repository, $dispatcher);

        $report = new Report();
        $report->query = [
            'fromDate' => Carbon::now()->subDay(),
            'toDate' => Carbon::now(),
            'paramA' => 'value',
            'paramB' => 123,
        ];

        $service->processNewReport(new Query(Carbon::now()->subDay(), Carbon::now(), 'value', 123));
    }
}
