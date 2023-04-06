<?php

namespace App\Models;

use App\Services\Reports\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property StatusEnum $status
 * @property array $query
 * @property string|null $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    /**
     * @var array
     */
    protected $attributes = [
        'status' => StatusEnum::PENDING,
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => StatusEnum::class,
        'query' => 'array',
    ];
}
