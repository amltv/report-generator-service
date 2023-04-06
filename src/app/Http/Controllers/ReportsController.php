<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewReportRequest;
use App\Http\Resources\ReportResource;
use App\Services\Reports\Repository;
use App\Services\Reports\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Cursor;

class ReportsController extends Controller
{
    public function list(Request $request, Repository $repository): JsonResponse
    {
        $request->validate([
            'limit' => ['integer', 'min:10'],
        ]);

        return ReportResource::collection($repository->getList(
            $request->get('limit', 20),
            Cursor::fromEncoded($request->input('cursor')),
        ))->response();
    }

    public function create(NewReportRequest $request, Service $service): JsonResponse
    {
        $report = $service->processNewReport($request->getQuery());

        return ReportResource::make($report)->response();
    }
}
