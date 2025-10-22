<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a new JSON response from the application.
     *
     * @param  mixed  $data
     * @param  int  $status
     * @param  array<string, string>  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */
    private function response(mixed $data = null, int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        if ($data['data'] == null) {
            // Remove data key if it is null
            unset($data['data']);
        }


        return response()->json($data, $status, $headers, $options);
    }

    /**
     * Return a new JSON response from the application with a 200 status.
     *
     * @param  mixed  $data
     * @param  array<string, string>  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(mixed $data, string $message, array $headers = [], int $options = 0): JsonResponse
    {
        return $this->response([
            'status' => 'Success',
            "message" => $message,
            'code' => 2000,
            'data' => $data
        ], 200, $headers, $options);
    }

    /**
     *
     */

    public function error(mixed $data, string $message, int $code = 4000): JsonResponse
    {
        return $this->response([
            'status' => 'Error',
            "message" => $message,
            'code' => $code,
            'data' => $data
        ], 200);
    }

    /**
     * Return a new JSON response from the application with a 201 status.
     *
     * @param  mixed  $data
     * @param  array<string, string>  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function created(mixed $data, array $headers = [], int $options = 0): JsonResponse
    {
        return $this->response([
            'status' => 'Created',
            'code' => 2001,
            'data' => $data
        ], 200, $headers, $options);
    }

    /**
     * Return a new JSON response from the application with a 500 status.
     *
     * @param  array<string, string>  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */

    public function internalError(mixed $data = null, string $message, array $headers = [], int $options = 0): JsonResponse
    {
        return $this->response([
            'status' => 'Internal Server Error',
            'message' => $message,
            'code' => 5000,
            'data' => $data
        ], 200, $headers, $options);
    }

    /**
     * Return a new JSON response from the application with a 404 status.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */

    public function notFound(mixed $data = null, string $message = 'Not Found'): JsonResponse
    {
        return $this->response([
            'status' => 'Not Found',
            'message' => $message,
            'code' => 4004,
            'data' => $data
        ], 200);
    }

    /**
     * Return a new JSON response from the application with a 400 status.
     *
     * @param  mixed  $data
     * @param  array<string, string>  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */

    public function badRequest(mixed $data = null, array $headers = [], int $options = 0, mixed $code = 4000): JsonResponse
    {
        return $this->response([
            'status' => 'Bad Request',
            'code' => $code,
            'data' => $data
        ], 200, $headers, $options);
    }

    /**
     * Return a new JSON response from the application with a 401 status.
     *
     * @param  mixed  $data
     * @param  array<string, string>  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */

    public function unauthorized(mixed $data = null, array $headers = [], int $options = 0): JsonResponse
    {
        return $this->response([
            'status' => 'Unauthorized',
            'code' => 4001,
            'data' => $data
        ], 200, $headers, $options);
    }

    /**
     * Return a new JSON response from the application with a 422 status.
     *
     * @param  mixed  $data
     * @param  array<string, string>  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */

    public function unprocessableEntity(mixed $data = null, array $headers = [], int $options = 0): JsonResponse
    {
        return $this->response([
            'status' => 'Validation Error',
            'code' => 4022,
            'data' => $data
        ], 200, $headers, $options);
    }

    public function pagination(mixed $data, string $name, string $key, string $resourceClass): array
    {
        return [
            $key => $resourceClass::collection($data[$name]->items()),
            "pagination" => [
                'current_page' => $data[$name]->currentPage(),
                'total_pages' => $data[$name]->lastPage(),
                'per_page' => $data[$name]->perPage(),
                'total_items' => $data[$name]->total(),
                'links' => [
                    'first' => $data[$name]->url(1),
                    'last' => $data[$name]->url($data[$name]->lastPage()),
                    'next' => $data[$name]->nextPageUrl(),
                    'prev' => $data[$name]->previousPageUrl(),
                ]
            ]
        ];
    }
}
