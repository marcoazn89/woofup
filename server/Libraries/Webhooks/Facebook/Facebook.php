<?php
namespace Roadbot\Libraries\Webhooks\Facebook;

use \Roadbot\Libraries\Webhooks\Interfaces\WebhookInterface;

class Facebook implements WebhookInterface
{
    protected $actions = [];

    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    public function handleAction($action, $data)
    {
        return $this->actions[$action]->handleAction($data);
    }
}
