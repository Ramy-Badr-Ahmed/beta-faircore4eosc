<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Livewire\Exceptions\CorruptComponentPayloadException;
use Illuminate\Support\Facades\Log;
use App\Http\Livewire\MetaData\MetaPanels;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Mailer\Exception\TransportException;
use Throwable;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Get the default context variables for logging.
     *
     * @return array<string, mixed>
     */
    protected function context(): array
    {
        return array_merge(parent::context(), [
            'userNameException' => Auth::user()->name ?? 'guest',
        ]);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            self::addLogs(json_encode($this->context()).' HandlerException: ' . get_class($e). ": " .$e->getMessage().": ".$e->getFile().": ".$e->getLine());
        });

        $this->renderable(function (Throwable $e, $request) {

            if ($e instanceof CorruptComponentPayloadException) MetaPanels::dumpDie();

            if(!config('app.enforce_https')){
                return null;
            }

            return match(true) {
                $e instanceof ValidationException     => $this->convertValidationExceptionToResponse($e, $request),

                $e instanceof AuthenticationException => $this->unauthenticated($request, $e),

                $e instanceof AuthorizationException,
                    $e instanceof HttpException && $e->getStatusCode() === 403
                        => redirect()
                        ->route('home')
                        ->with('verifyError', 'Unauthorized action: ' . ($e->getStatusCode() ?? $e->getMessage()) . '<br>Please request a New Verification Link.'),

                $e instanceof TransportException => redirect()
                    ->route('password.request')
                    ->with('emailError', 'Is your email address still valid?!'),

                default => redirect()
                    ->route('home')
                    ->with('reportError', '500-Level error has occurred!<br>Kindly report your very last activity to us.<br>Thank you!')
            };
        });
    }

    public static function addLogs(string $errorLog): void
    {
        Log::channel('exceptionLogs')->error($errorLog);
    }
}
