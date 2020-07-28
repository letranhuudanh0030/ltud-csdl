<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Admin Documentation",
     *      description="Admin OpenApi description",
     *      @OA\Contact(
     *          email="danh.le1997@hcmut.com"
     *      ),
     * )
     */

    /**
     *  @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Admin API server"
     *  )
     */

    /**
     * @OA\SecurityScheme(
     *     type="oauth2",
     *     description="Use a global client_id / client_secret and your username / password combo to obtain a token",
     *     name="Password Based",
     *     in="header",
     *     scheme="https",
     *     securityScheme="Password Based",
     *     @OA\Flow(
     *         flow="password",
     *         authorizationUrl="/oauth/authorize",
     *         tokenUrl="/oauth/token",
     *         refreshUrl="/oauth/token/refresh",
     *         scopes={}
     *     )
     * )
     */

    /**
     * @OA\OpenApi(
     *   security={
     *     {
     *       "oauth2": {"read:oauth2"},
     *     }
     *   }
     * )
     */

}
