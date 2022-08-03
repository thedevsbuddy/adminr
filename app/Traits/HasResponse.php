<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

trait HasResponse
{
    public function success($data, $statusCode = 200, $status = "success", $message = "Success"): JsonResponse
    {
        return response()->json(["status" => $status, 'message' => $message, 'data' => $data], $statusCode);
    }

    public function successMessage($message, $statusCode = 200): JsonResponse
    {
        return response()->json(["status" => "success", 'message' => $message], $statusCode);
    }

    public function error($message, $statusCode = 500): JsonResponse
    {
        return response()->json(["status" => "error", 'message' => $message], $statusCode);
    }

    public function errorOk($message, $statusCode = 200): JsonResponse
    {
        return response()->json(["status" => "error", 'message' => $message], $statusCode);
    }

    public function errorMessage($message, $statusCode = 500): JsonResponse
    {
        return response()->json(["status" => "error", 'message' => $message], $statusCode);
    }


    public function redirect($route, string $status, string $message): RedirectResponse
    {
        return redirect($route)->with($status, $message);
    }

    public function redirectSuccess(string $route, ?string $message = 'Operation was successful!'): RedirectResponse
    {
        return $this->redirect($route, 'success', $message);
    }

    public function intendedSuccess(string $route, ?string $message = 'Operation was successful!'): RedirectResponse
    {
        return redirect()->intended($route)->with('success', $message);
    }

    public function redirectError(string $route, ?string $message = 'Operation was unsuccessful!'): RedirectResponse
    {
        return $this->redirect($route, 'error', $message);
    }

    public function intendedError(string $route, ?string $message = 'Operation was unsuccessful!'): RedirectResponse
    {
        return redirect()->intended($route)->with('error', $message);
    }



    public function backSuccess(?string $message = 'Operation was successful!'): RedirectResponse
    {
        return back()->with('success', $message);
    }

    public function backError(?string $message = 'Operation was unsuccessful!'): RedirectResponse
    {
        return back()->with('error', $message);
    }
}
