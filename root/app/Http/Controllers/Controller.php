<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\AuthorizationException;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @param $data
     * @param int $statusCode
     * @param string|null $messages
     * @return JsonResponse
     */
    public function responseSuccess($data, int $statusCode, string $messages = null): JsonResponse
    {
        $response = [
            'success' => true,
            'code' => $statusCode,
            'message' => $messages,
            'data' => $data
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * @param int $httpCode
     * @param string $messages
     * @return JsonResponse
     */
    public function responseError(int $statusCode, string $messages): JsonResponse
    {
        $response = [
            'success' => false,
            'code' => $statusCode,
            'errors' => [
                'error_message' => $messages,
            ],
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * @param $result
     * @param $codeSuccess
     * @param $codeError
     * @return JsonResponse
     */
    public function responseForm($result, $codeSuccess, $codeError): JsonResponse
    {
        if ($result['status']) {
            return $this->responseSuccess($result, $codeSuccess, $result['message']);
        }
        return $this->responseError($codeError, $result['message']);
    }

    /**
     * @param $e
     * @return void
     */
    public function logError($e)
    {
        $message = $e->getMessage() . ' ' . $e->getFile() . ':' . $e->getLine();
        Log::error($message);

        if ($e instanceof ModelNotFoundException) {
            throw new \Exception(__('message.E0038'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof ErrorException) {
            throw new \ErrorException($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        
        if ($e instanceof AuthorizationException) {
            throw new AuthorizationException($e->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
