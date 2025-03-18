<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface BrandServiceInterface
{
    public function paginate($request);

    public function create($data);
}
