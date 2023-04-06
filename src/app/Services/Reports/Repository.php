<?php

namespace App\Services\Reports;

use App\Models\Report;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Pagination\Cursor;

interface Repository
{
    /**
     * @param Query $query
     * @return Report
     */
    public function create(Query $query): Report;

    /**
     * @param Report $report
     * @return void
     */
    public function update(Report $report): void;

    /**
     * @param int $limit
     * @param Cursor|null $cursor
     * @return CursorPaginator
     */
    public function getList(int $limit, ?Cursor $cursor): CursorPaginator;
}
