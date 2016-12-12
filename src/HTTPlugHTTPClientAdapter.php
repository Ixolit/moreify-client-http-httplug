<?php

namespace Ixolit\Moreify\HTTP\HTTPlug;

use Http\Client\Curl\Client;
use Http\Client\Exception\RequestException;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Http\Message\StreamFactory\GuzzleStreamFactory;
use Ixolit\Moreify\Interfaces\HTTPClientAdapter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class HTTPlugHTTPClientAdapter implements HTTPClientAdapter {
    private $client;

    public function __construct() {
        $this->client = new Client(new GuzzleMessageFactory(), new GuzzleStreamFactory());
    }


    /**
     * @return RequestInterface
     */
    public function createRequest() {
        return new Request('GET', '/');
    }

    /**
     * @return UriInterface
     */
    public function createUri() {
        return new Uri();
    }

    /**
     * @param string $string
     *
     * @return StreamInterface
     */
    public function createStringStream($string) {
        return \GuzzleHttp\Psr7\stream_for($string);
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request) {
        try {
            return $this->client->sendRequest($request);
        } catch (RequestException $e) {
            return $e->getRequest();
        }
    }
}