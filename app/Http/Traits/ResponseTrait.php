<?php

namespace App\Http\Traits;

trait ResponseTrait
{
    public function errors(int $code = 422, string $message = 'Invalid fields', mixed $errors = null)
    {
        $errorPayload = [
            "message" => $message
        ];

        if($errors) $errorPayload["errors"] = $errors;

        return response()->json($errorPayload, $code);
    }
}
