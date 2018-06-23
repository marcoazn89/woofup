<?php
namespace Roadbot\Libraries\Webhooks\Interfaces;

use \Psr\Http\Message\RequestInterface;

interface WebhookInterface
{
    /**
     * Makes a \GuzzleHttp\Psr7\Request object based on an action
     * @param  string $action The action to be taken
     * @param  array $data   The data to be used by the action
     * @return mixed
     */
    public function handleAction($action, $data);
}
