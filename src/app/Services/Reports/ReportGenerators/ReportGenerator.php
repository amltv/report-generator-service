<?php

namespace App\Services\Reports\ReportGenerators;

use App\Services\Reports\Query;
use Psr\Http\Message\StreamInterface;
use Throwable;

interface ReportGenerator
{
    /**
     * @param Query $query
     * @return StreamInterface
     * @throws Throwable
     */
    public function generate(Query $query): StreamInterface;
}
