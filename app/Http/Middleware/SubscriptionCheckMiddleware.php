<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Services\v1\OrganizationLogic\OrganizationService;
use Closure;

class SubscriptionCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */


    protected $organizationService;

    /**
     * ChangePasswordApiRequest constructor.
     * @param $organizationService
     */
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    //TODO ADD REDIS BECAUSE OF PERFORMANCE ISSUES
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if ($user && ($user->isEmployee() || $user->isOwner())) {
            if ($user->employee && $user->employee->organization_id) {
                $subscription = $this->organizationService
                    ->getCurrentSubscriptionOfOrganization($user->employee->organization_id);
                if ($subscription) {
                    return $next($request);
                }
            }
        } else {
            return $next($request);
        }
        throw new ApiServiceException(400, false, [
            'errors' => [
                'Your subscription expired'
            ],
            'errorCode' => ErrorCode::SUBSCRIPTION_EXPIRED,
        ]);

    }
}
