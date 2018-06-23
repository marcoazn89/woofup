<?php
namespace Woofup\Controllers;

use Woofup\Libraries\Exceptions\ApiException;
use Psr\Http\Message\{RequestInterface, ResponseInterface};
use Monolog\Logger;
use Throwable;
use Woofup\Libraries\Profile\ProfileService;
class ProfileCtrl
{
    protected $logger;
    protected $service;

    public function __construct(ProfileService $profileService)
    {
        //$this->logger = $logger;
        $this->service = $profileService;
    }

    public function getProfile(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $profileData = $this->service->getProfileData();
        //die(var_dump($testRes));
        //return $response->withStatus(200)->writeJson(['a' => 'test']);
        return $response->withStatus(200)->writeJson($profileData);
    }

    public function setProfile(RequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        //die(print_r($request->getParams()));
        $data = json_encode($request->getParams());
        //$profData = json_encode($request->$params);
        //return $response->withStatus(200)->writeJson(['a' => 'test']);
         $this->service->setProfile($data);
         //$test = $this->service->getProfileData();
        // die(var_dump($test));
         return $response->withStatus(200)->write($data);
    }
}