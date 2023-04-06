<?php

namespace App\Services\Reports;

use App\Models\Report;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Pagination\Cursor;

class EloquentRepository implements Repository
{
    public function create(Query $query): Report
    {
        $report = new Report();
        $report->query = (array) $query;

        $report->saveOrFail();

        return $report;
    }

    public function update(Report $report): void
    {
        $report->saveOrFail();
    }

    public function getList(int $limit, ?Cursor $cursor): CursorPaginator
    {
        return Report::query()
            ->orderBy('id', 'desc')
            ->cursorPaginate($limit, cursor: $cursor);
    }
}
