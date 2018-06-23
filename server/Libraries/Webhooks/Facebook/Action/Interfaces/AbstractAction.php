<?php
namespace Roadbot\Libraries\Webhooks\Facebook\Action\Interfaces;

use \GuzzleHttp\ClientInterface;
use \Illuminate\Database\MySqlConnection;

abstract class AbstractAction
{
    protected $httpClient;
    protected $db;
    protected $url;
    protected $conversations;

    public function __construct(ClientInterface $httpClient, MySqlConnection $db, $url, $conversations)
    {
        $this->httpClient = $httpClient;
        $this->db = $db;
        $this->url = $url;
        $this->conversations = $conversations;
    }

    /**
     * Handles actions
     *
     * The implementation can make their own assumptions
     * on what to expect from the data received.
     *
     * @param  array $data Data to be processed
     * @return array       Data to be sent
     */
    public abstract function handleAction(array $data);

    protected function getRequestData($userId, $message, $metadata = '')
    {
        return $this->requestData =  [
            'recipient' => ['id' => $userId],
            'message' => ['text' => $message, 'metadata' => $metadata]
        ];
    }
}
