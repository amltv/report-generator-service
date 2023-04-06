<?php

namespace App\Services\Reports\ReportGenerators;

use App\Services\Reports\Query;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamInterface;

class StubReportGenerator implements ReportGenerator
{
    public function generate(Query $query): StreamInterface
    {
        sleep(rand(30, 60)); // doing something great

        $resource = tmpfile();

        fputcsv($resource, ['col1, col2, col']);
        fputcsv($resource, ['1, a, b']);

        return Utils::streamFor($resource);
    }
}
