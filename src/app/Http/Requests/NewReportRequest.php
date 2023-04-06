<?php

namespace App\Http\Requests;

use App\Services\Reports\Query;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class NewReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return Query
     */
    public function getQuery(): Query
    {
        return new Query(
            Carbon::make($this->get('from_date')),
            Carbon::make($this->get('to_date')),
            $this->get('param_a', 'foo'),
            $this->get('param_b', 0),
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date', 'after:from_date'],
            'param_a' => ['string'],
            'param_b' => ['integer'],
        ];
    }
}
