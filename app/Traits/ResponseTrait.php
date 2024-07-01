<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{


    /**
     * @param  $result
     * @param string $message
     * @param int $code
     * @param string $key
     * @return JsonResponse
     */
    public function successResponse($result, string $message, int $code = 200, string $key = "data"): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        $response[$key] = $result;

        return response()->json($response, $code);
    }


    /**
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($error, array $errorMessages = [], int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
