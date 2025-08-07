<?php

use App\Http\Middleware\AuthorizeByRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => AuthorizeByRole::class
        ]);

        $middleware->redirectUsersTo(function (Request $request) {
            $user = $request->user();

            if (!$user) {
                return route('login');
            }

            if ($user->role == 'volunteer')
            {
                return route('volunteer.events.index');
            }
            else if ($user->role == 'organization')
            {
                return route('organization.events.index');
            }
            else if ($user->role == 'admin')
            {
                return route('admin.events.index');
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        $getRoleSpecificLayout = function (Request $request) {
            $user = $request->user();
            return match ($user->role ?? null) {
                'volunteer'    => 'layouts.volunteer',
                'organization' => 'layouts.organization',
                'admin'        => 'layouts.admin',
                default        => 'layouts.guest',
            };
        };

        $exceptions->render(function (HttpException $e, Request $request) use ($getRoleSpecificLayout) {

            if (!config('app.debug')) {
                $layout = $getRoleSpecificLayout($request);
                $statusCode = $e->getStatusCode();
                $defaultMessage = $e->getMessage() ?: 'Terjadi kesalahan yang tidak terduga.';
    
                return response()->view(
                    'errors.index',
                    [
                        'layout' => $layout,
                        'statusCode' => $statusCode,
                        'message' => $defaultMessage
                    ],
                    status: $statusCode
                );
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) use ($getRoleSpecificLayout) {
            
            if (!config('app.debug')) {
                $layout = $getRoleSpecificLayout($request);
                $statusCode = 500;
                $defaultMessage = 'Terjadi kesalahan pada server. Silakan coba lagi nanti.';
    
                return response()->view(
                    'errors.index',
                    [
                        'layout' => $layout,
                        'statusCode' => $statusCode,
                        'message' => $defaultMessage
                    ],
                    status: $statusCode
                );
            }
        });

    })->create();
