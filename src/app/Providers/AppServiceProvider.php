<?php

namespace App\Providers;

use App\Services\Reports\EloquentRepository;
use App\Services\Reports\Processor;
use App\Services\Reports\ReportGenerators\ReportGenerator;
use App\Services\Reports\ReportGenerators\StubReportGenerator;
use App\Services\Reports\Repository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Repository::class, EloquentRepository::class);

        $this->app->bind(ReportGenerator::class, StubReportGenerator::class);

        $this->app->bind(Processor::class, fn() => new Processor(
            $this->app->get(Repository::class),
            Storage::disk('reports'),
            $this->app->get(ReportGenerator::class),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
