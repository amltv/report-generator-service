<?php

namespace Tests\Unit;

use App\Models\Report;
use App\Services\Reports\Processor;
use App\Services\Reports\Query;
use App\Services\Reports\ReportGenerators\ReportGenerator;
use App\Services\Reports\Repository;
use App\Services\Reports\StatusEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use Tests\TestCase;

class ProcessorTest extends TestCase
{
    public function testSuccessFlow(): void
    {
        $reportGenerator = $this->createMock(ReportGenerator::class);
        $reportGenerator->expects($this->once())->method('generate')->with($this->callback(function (Query $query) {
            $this->assertInstanceOf(Carbon::class, $query->fromDate);
            $this->assertInstanceOf(Carbon::class, $query->toDate);
            $this->assertEquals('value', $query->paramA);
            $this->assertEquals(123, $query->paramB);

            return true;
        }));

        $processor = new Processor(
            $this->createStub(Repository::class),
            $this->createStub(Filesystem::class),
            $reportGenerator,
        );

        $report = new Report();
        $report->query = [
            'fromDate' => Carbon::now()->subDay(),
            'toDate' => Carbon::now(),
            'paramA' => 'value',
            'paramB' => 123,
        ];

        $processor->process($report);

        $this->assertEquals($report->status, StatusEnum::READY);
        $this->assertNotEmpty($report->path);
    }

    public function testReportGeneratorThrowException(): void
    {
        $reportGenerator = $this->createMock(ReportGenerator::class);
        $reportGenerator->expects($this->once())->method('generate')->willThrowException(new \Exception());

        $processor = new Processor(
            $this->createStub(Repository::class),
            $this->createStub(Filesystem::class),
            $reportGenerator,
        );

        $report = new Report();
        $report->query = [
            'fromDate' => Carbon::now()->subDay(),
            'toDate' => Carbon::now(),
            'paramA' => 'value',
            'paramB' => 123,
        ];

        $processor->process($report);

        $this->assertEquals($report->status, StatusEnum::FAILED);
        $this->assertNotEmpty($report->path);
    }
}
