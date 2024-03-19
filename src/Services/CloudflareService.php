<?php

namespace yandinovriandi\Cloudflare\Services;

use BadMethodCallException;
use Config;
use InvalidArgumentException;
use yandinovriandi\Cloudflare\Http\HttpClient;

class CloudflareService
{
    /**
     * Get auth parameters from config, fail if any are missing.
     * Instantiate API client and set auth bearer token.
     *
     * @throws Exception
     */
    public function __construct(
        public string $email = '',
        private string $token = '',
        public HttpClient $client = new HttpClient,
    ) {
        $this->token = ($this->token) ? $this->token : config('cloudflare-laravel.token');
        $this->email = ($this->email) ? $this->email : config('cloudflare-laravel.email');

        if (!$this->token || !$this->email) {
            throw new InvalidArgumentException('Please set CLOUDFLARE_TOKEN && CLOUDFLARE_EMAIL environment variables.');
        }

        $this->client->setAuth('bearer', ['token' => $this->token, 'email' => $this->email]);
    }

    /**
     * Pass any method calls onto $this->client
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (is_callable([$this->client, $method])) {
            return call_user_func_array([$this->client, $method], $args);
        } else {
            throw new BadMethodCallException("Method $method does not exist");
        }
    }

    /**
     * Pass any property calls onto $this->client
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this->client, $property)) {
            return $this->client->{$property};
        } else {
            throw new BadMethodCallException("Property $property does not exist");
        }
    }
}
