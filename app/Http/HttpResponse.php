<?php

declare(strict_types=1);

namespace App\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseHelper;

class HttpResponse
{

    private $data = [];

    private $statusCode = ResponseHelper::HTTP_OK;

    private $success = true;

    public static function make(): HttpResponse
    {
        return new static;
    }

    public function withData($data): HttpResponse
    {
        $this->data = $data;

        return $this;
    }

    public function send($data = null): JsonResponse
    {
        if ($data instanceof JsonResource) {
            $this->data = $data->toArray(request());
        }

        if (is_array($data)) {
            $this->data = $data;
        }

        $data = [
            'success' => $this->success,
            'response' => $this->data,
        ];

        if (empty($data['response'])) {
            $data['response'] = (object) [];
        }

        return response()->json($data, $this->statusCode);
    }

    public function serverError(): HttpResponse
    {
        return $this->failed(ResponseHelper::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function failed(int $statusCode): HttpResponse
    {
        $this->success = false;
        $this->statusCode = in_array($statusCode, array_keys(ResponseHelper::$statusTexts))
            ? $statusCode
            : ResponseHelper::HTTP_INTERNAL_SERVER_ERROR;

        return $this;
    }
}
