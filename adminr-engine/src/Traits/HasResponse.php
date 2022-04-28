<?php

namespace Devsbuddy\AdminrEngine\Traits;

trait HasResponse
{
    /**
     * @param $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data, $statusCode = 200)
    {
        if (is_array($data)) {
            return response()->json($data, $statusCode);
        }
        return response()->json(['message' => "success", 'data' => $data], $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successMessage($message, $statusCode = 200)
    {
        return response()->json(['message' => $message], $statusCode);
    }


    /**
     * @param $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $statusCode = 500)
    {
        return response()->json(['message' => $message], $statusCode);
    }

    /**
     * Return redirect user to provided route
     * with provided status and message
     *
     * @param string $route
     * @param string $status
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect($route, string $status, string $message)
    {
        return redirect($route)->with($status, $message);
    }

    /**
     * Return redirect user to provided route
     * with success message
     *
     * @param string $route
     * @param string|null $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectSuccess(string $route, ?string $message = 'Operation was successful!')
    {
        return $this->redirect($route, 'success', $message);
    }

    /**
     * Return redirect user to provided route
     * with error message
     *
     * @param string $route
     * @param string|null $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectError(string $route, ?string $message = 'Operation was unsuccessful!')
    {
        return $this->redirect($route, 'error', $message);
    }

    /**
     * Return redirect user to previous route
     * with success message
     *
     * @param string|null $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backSuccess(?string $message = 'Operation was successful!')
    {
        return back()->with('success', $message);
    }

    /**
     * Return redirect user to previous route
     * with error message
     *
     * @param string|null $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backError(?string $message = 'Operation was unsuccessful!')
    {
        return back()->with('error', $message);
    }
}
