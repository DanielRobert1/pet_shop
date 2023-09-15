<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HasApiResponse;
use Illuminate\Http\JsonResponse;

class FallbackController extends Controller
{
    use HasApiResponse;

    /**
     * @return JsonResponse
     */
    final public function missing(): JsonResponse
    {
        return $this->sendError("The resource you're looking for was not found", HTTP_STATUS_NOT_FOUND);
    }
}
