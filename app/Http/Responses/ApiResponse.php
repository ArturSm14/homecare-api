<?php

namespace App\Http\Responses;

use Exception;

class ApiResponse
{
    /**
     * @param $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function created($data = null, $message = 'Criado com sucesso')
    {
        return response()->json([
            'status'    => true,
            'response'  => $data,
            'message'   => $message
        ], 201);
    }
    /**
     * @param \Exception|null $data
     * @param string $message
     * @param int $status
     * @param bool $paramError
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($data = null, $message = 'Error', $status = 400, $paramError = false)
    {
        if ($data instanceof \Exception) {
            $code = $data->getCode();
            $code = ($code >= 400 && $code <= 599) ? $code : $status;

            return response()->json(
                [
                    'status'      => false,
                    'response'    => self::mountErrorResponse($data),
                    'message'     => $data->getMessage(),
                    'paramError'  => $data->getMessage()
                ],
                $code
            );
        }

        return response()->json([
            'status'      => false,
            'response'    => $data,
            'message'     => $message,
            'paramError'  => $paramError
        ], $status);
    }
    /**
     * @param $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = 'Sucess', int $status = 200)
    {
        return response()->json([
            'status'    => true,
            'response'  => $data,
            'message'   => $message
        ], $status);
    }

    private static function mountErrorResponse(\Exception $exception)
    {
        $response = [$exception->getMessage()];
        if (env('APP_ENV') != 'production')
            array_push($response, $exception->getFile(), $exception->getLine());
        return $response;
    }
}
