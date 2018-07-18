<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use App\Category;

class CheckCategoryForPrivacy
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
        $userId = Auth::user()->id;
        $category = Category::findOrFail($request->id);

        if ($category->hasAccess($userId)) {
          return $next($request);
        }

        abort(404);
    }
}
