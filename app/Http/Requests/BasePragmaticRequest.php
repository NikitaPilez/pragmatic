<?php

namespace App\Http\Requests;

use App\Services\PragmaticErrorCodesService;
use App\Services\PragmaticServiceInterface;
use Illuminate\Foundation\Http\FormRequest;

class BasePragmaticRequest extends FormRequest
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
        return false;
    }

    protected function prepareForValidation(): void
    {
        if ($this->shouldVerifyHash()) {
            if (! $this->verifyRequestHash()) {
                 abort(response()->json([
                     'error' => PragmaticErrorCodesService::getInvalidHashCode(),
                     'description' => 'Invalid hash',
                ], 400));
            }
        }

    }

    public function verifyRequestHash(): bool
    {
        /** @var PragmaticServiceInterface $pragmaticService */
        $pragmaticService = app(PragmaticServiceInterface::class);

        return $pragmaticService->checkValidHash($this->all());
    }
}
