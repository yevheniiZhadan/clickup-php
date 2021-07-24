<?php

namespace ClickUp\Middleware;

use Exception;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * Class AuthRequest
 * @package ClickUp\Middleware
 */
class AuthRequest extends AbstractMiddleware
{
    /**
     * Invoke
     *
     * @param callable $handler
     * @return callable
     */
    public function __invoke(callable $handler)
    {
        $self = $this;

        return function (RequestInterface $request, array $options) use ($self, $handler) {
            $accessToken = $self->client->getOptions()->getAccessToken();

            if ($accessToken === null) {
                throw new Exception('Access Token parameter is required');
            }

            $request = $request->withHeader('Authorization', $accessToken);

            return $handler($request, $options);
        };
    }
}
