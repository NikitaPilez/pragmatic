<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AuthenticateRequest extends BasePragmaticRequest
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
            'token' => 'required|string',
            'providerId' => 'required|string',
            'gameId' => 'nullable',
            'ipAddress' => 'nullable',
            'chosenBalance' => 'nullable',
            'launchingType' => [
                'nullable',
                Rule::in(['N', 'L']),
            ],
            'previousToken' => 'nullable',
        ];
    }
}
