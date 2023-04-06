<?php

namespace Database\Factories;

use App\Services\Reports\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => StatusEnum::READY,
            'query' => ['a' => 1, 'b' => 2],
            'path' => Str::random(10),
        ];
    }
}
