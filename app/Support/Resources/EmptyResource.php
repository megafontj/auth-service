<?php

namespace App\Support\Resources;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmptyResource implements Responsable
{
    public function toResponse($request)
    {
        return response(['data' => null]);
    }
}
