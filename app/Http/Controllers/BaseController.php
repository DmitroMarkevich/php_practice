<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Validate incoming data against the provided rules.
     *
     * @param array $data The data to be validated.
     * @param array $rules The validation rules to apply.
     * @return void
     * @throws ValidationException If validation fails, an exception is thrown.
     */
    protected function validateRequest(array $data, array $rules): void
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
