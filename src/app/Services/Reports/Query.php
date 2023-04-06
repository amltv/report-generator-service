<?php

namespace App\Services\Reports;

use Carbon\Carbon;

class Query
{
    public function __construct(
        public readonly Carbon $fromDate,
        public readonly Carbon $toDate,
        public readonly string $paramA,
        public readonly int $paramB,
    ) {}

    public static function createFromArray(array $data): self
    {
        return new self(
            Carbon::make($data['fromDate']),
            Carbon::make($data['toDate']),
            $data['paramA'],
            $data['paramB'],
        );
    }
}
