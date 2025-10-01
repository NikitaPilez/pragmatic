<?php

namespace App\Http\Requests;

class GetBalanceRequest extends BasePragmaticRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
            'providerId' => 'required',
            'userId' => 'required',
            'token' => 'nullable',
        ];
    }
}
