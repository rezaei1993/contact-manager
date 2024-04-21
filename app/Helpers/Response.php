<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Response
{
    protected int $statusCode = 200;

    protected array $errors = [];

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }


    protected function respondWithError($message): JsonResponse
    {
        $response = [
            'message' => $message,
            'status' => 'fail',
            'status_code' => $this->getStatusCode(),
        ];

        return $this->respond($response);
    }

    protected function respond(array $data, array $headers = []): JsonResponse
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }


    public function respondSuccess($data = [], $message = 'Operation was successful'): JsonResponse
    {
        return $this->setStatusCode(ResponseAlias::HTTP_OK)
            ->respond([
                'message' => $message,
                'status' => 'Success',
                'status_code' => $this->getStatusCode(),
                'data' => $data,
            ]);
    }

    public function respondBadRequest($message = 'Bad Request.', int $code = ResponseAlias::HTTP_BAD_REQUEST): JsonResponse
    {
        return $this->setStatusCode($code)->respondWithError($message);
    }

}

