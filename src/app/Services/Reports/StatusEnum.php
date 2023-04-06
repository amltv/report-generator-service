<?php

namespace App\Services\Reports;

enum StatusEnum:string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case READY = 'ready';
    case FAILED = 'failed';
}
