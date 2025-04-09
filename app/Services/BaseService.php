<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;

/**
 * Class UserService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    protected $controllerName;


    public function formatJson($request, $inputName)
    {
        return ($request->input($inputName) && !empty($request->input($inputName))) ? json_encode($request->input($inputName)) : '';
    }
}
