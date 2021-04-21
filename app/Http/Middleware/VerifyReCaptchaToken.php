<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as ValidatorFactory;

/**
 * Class VerifyReCaptchaToken
 * @package App\Http\Middleware
 */
class VerifyReCaptchaToken
{
    /**
     * VerifyReCaptchaToken constructor.
     * @param ValidatorFactory $validator
     */
    public function __construct(private ValidatorFactory $validator)
    { }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $validator = $this->validator->make($request->all(), [
            'g-recaptcha-response' => 'recaptcha',
        ], [
            'g-recaptcha-response.recaptcha' => 'Invalid ReCaptcha code',
        ]);

        if($validator->fails()) {
            return new JsonResponse([
                'error' => true,
                'message' => $validator->errors()->all()
            ]);
        }

        return $next($request);
    }
}
