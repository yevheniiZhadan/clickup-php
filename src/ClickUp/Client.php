<?php

namespace ClickUp;

use ClickUp\Middleware\AuthRequest;
use ClickUp\Middleware\RateLimiting;
use ClickUp\Middleware\UpdateApiLimits;
use ClickUp\Middleware\UpdateRequestTime;
use ClickUp\Objects\TaskFinder;
use ClickUp\Objects\Team;
use ClickUp\Objects\TeamCollection;
use ClickUp\Objects\User;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Utils;
use GuzzleRetry\GuzzleRetryMiddleware;

/**
 * Class Client
 * @package ClickUp
 */
class Client
{
    /**
     * @var GuzzleHttpClient
     */
    private $guzzleClient;

    /**
     * The handler stack.
     *
     * @var HandlerStack
     */
    private $handlerStack;

    /**
     * Options
     *
     * @var Options
     */
    private $options;

    /**
     * Store options
     *
     * @var StoreOptions
     */
    private $storeOptions;

    /**
     * Client constructor.
     *
     * @param  Options  $options
     * @param  StoreOptions|null  $storeOptions
     */
    public function __construct(Options $options, ?StoreOptions $storeOptions = null)
    {
        $this->setOptions($options);
        $this->setStoreOptions($storeOptions ?? new StoreOptions());

        $this->setGuzzleClient();
    }

    /**
     * @return void
     */
    protected function setGuzzleClient()
    {
        $this->handlerStack = HandlerStack::create($this->getOptions()->getGuzzleHandler());
        $this->addMiddleware(new AuthRequest($this), 'request:auth')
             ->addMiddleware(new UpdateApiLimits($this), 'rate:update')
             ->addMiddleware(new UpdateRequestTime($this), 'time:update')
             ->addMiddleware(GuzzleRetryMiddleware::factory(), 'request:retry')
             ->addMiddleware(new RateLimiting($this), 'rate:limiting');

        $this->getOptions()->setGuzzleOptions(
            ['base_uri' => $this->getOptions()->getUriWithVersion()]
        );

        $this->guzzleClient = new GuzzleHttpClient(array_merge(
            ['handler' => $this->handlerStack],
            $this->getOptions()->getGuzzleOptions()
        ));
    }

    /**
     * @param  Options  $options
     */
    public function setOptions(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @return Options
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    /**
     * @param  StoreOptions  $storeOptions
     */
    public function setStoreOptions(StoreOptions $storeOptions)
    {
        $this->storeOptions = $storeOptions;
    }

    /**
     * @return StoreOptions
     */
    public function getStoreOptions(): StoreOptions
    {
        return $this->storeOptions;
    }

    /**
     * @param callable $callable
     * @param  string  $name
     *
     * @return Client
     */
    public function addMiddleware(callable $callable, string $name = ''): Client
    {
        $this->handlerStack->push($callable, $name);
        return $this;
    }

    /**
     * @return $this
     */
    public function client()
    {
        return $this;
    }

    /**
     * @return User
     * @throws GuzzleException
     */
    public function user(): User
    {
        return new User($this, $this->get('user')['user']);
    }

    /**
     * @param  string  $method
     * @param  array  $params
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function get(string $method, array $params = [])
    {
        $response = $this->guzzleClient->request('GET', $method, ['query' => $params]);
        return Utils::jsonDecode($response->getBody(), true);
    }

    /**
     * @return TeamCollection
     * @throws GuzzleException
     */
    public function teams(): TeamCollection
    {
        return new TeamCollection(
            $this,
            $this->get('team')['teams']
        );
    }

    /**
     * @param $teamId
     *
     * @return Team
     * @throws GuzzleException
     */
    public function team($teamId): Team
    {
        return $this->teams()->getByKey($teamId);
    }

    /**
     * @param  int  $teamId
     *
     * @return TaskFinder
     */
    public function taskFinder(int $teamId): TaskFinder
    {
        return new TaskFinder($this, $teamId);
    }

    /**
     * @param  string  $method
     * @param  array  $body
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function post(string $method, array $body = [])
    {
        return Utils::jsonDecode(
            $this->guzzleClient->request('POST', $method, ['json' => $body])->getBody(),
            true
        );
    }

    /**
     * @param  string  $method
     * @param  array  $body
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function put(string $method, array $body = [])
    {
        return Utils::jsonDecode(
            $this->guzzleClient->request('PUT', $method, ['json' => $body])->getBody(),
            true
        );
    }
}
