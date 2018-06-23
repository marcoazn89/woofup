<?php
namespace Roadbot\Controllers;

use Roadbot\Libraries\Exceptions\ApiException;
use Messenger\{WebhookService, GraphApi};
use ChatFlow\StateManager;
use Psr\Http\Message\{RequestInterface, ResponseInterface};
use Monolog\Logger;
use Throwable;

class FacebookCtrl
{
    protected $service;
    protected $api;
    protected $brain;
    protected $logger;

    public function __construct(WebhookService $service, GraphApi $api, StateManager $brain, Logger $logger)
    {
        $this->service = $service;
        $this->api = $api;
        $this->brain = $brain;
        $this->logger = $logger;
    }

    public function handleEvents(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $rq = file_get_contents('php://input');

        $this->logger->debug('FB_POST_EVENT ' . $rq);

        try {
            $eventData = json_decode($rq, true);

            foreach ($this->service->processData($eventData['entry']) as $obj) {
                // Get user id
                $userId = $obj->getSender();
                
                // Get user
                $user = $this->api->getUserData($userId);

                // Set up the brain for the user id
                $this->brain->setUp($userId, 'default');

                // Make variables accessible in the brain
                $this->brain->addData([
                    'user_id' => $userId,
                    'user' => $user
                ]);

                switch ($obj->getType()) {
                    case 'read':
                        $this->logger->debug('message read');
                        break;
                    case 'delivery':
                        $this->logger->debug('message delivered');
                        break;
                    case 'postback':
                    case 'text':
                    case 'attachments':
                        $this->logger->debug($obj->getType());
                        $this->brain->addData([
                            'input' => $obj
                        ]);
                        $this->brain->run($obj);
                        break;
                }
            }
        } catch (Throwable $e) {
            $this->logger->critical($e->getTraceAsString());
            $this->logger->critical($e->getMessage());
        }

        return $response->withStatus(200);
    }
}