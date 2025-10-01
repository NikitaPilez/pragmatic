<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class BetRequest extends BasePragmaticRequest
{
    protected function shouldVerifyHash(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hash' => 'required|string',
            'userId' => 'required',
            'gameId' => 'required',
            'roundId' => 'required',
            'amount' => 'required|numeric',
            'reference' => 'required',
            'providerId' => 'required',
            'timestamp' => 'required',
            'roundDetails' => 'required',
            'bonusCode' => 'nullable',
            'platform' => ['nullable', Rule::in(['MOBILE', 'WEB'])],
            'language' => 'nullable',
            'jackpotContribution' => 'nullable',
            'jackpotDetails' => 'nullable',
            'jackpotId' => 'nullable',
            'token' => 'nullable',
            'ipAddress' => 'nullable',
        ];
    }
}
