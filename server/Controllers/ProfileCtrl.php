<?php
namespace Woofup\Controllers;

use Woofup\Libraries\Exceptions\ApiException;
use Psr\Http\Message\{RequestInterface, ResponseInterface};
use Monolog\Logger;
use Throwable;

class ProfileCtrl
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function getProfile(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $response->withStatus(200)->writeJson(['a' => 'test']);
    }
}