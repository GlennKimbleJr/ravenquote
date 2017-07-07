<?php

namespace App\Http\Middleware;

use Closure;
use App\Form;
use App\FormSubmission;

class IsFormOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $submissionId = explode('/', $request->getRequestUri());
        $formId = FormSubmission::whereId(end($submissionId))->firstOrFail(['form_id'])['form_id'];
        $ownerId = (int) Form::whereId($formId)->first(['user_id'])['user_id'];

        if (auth()->user()->id !== $ownerId) {
            throw new \App\Exceptions\UnauthorizedAccessException;
        }

        return $next($request);
    }
}
