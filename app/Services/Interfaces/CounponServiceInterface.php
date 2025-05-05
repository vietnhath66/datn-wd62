<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface CounponServiceInterface
{
    public function paginate($request);

    public function create($data);
}
