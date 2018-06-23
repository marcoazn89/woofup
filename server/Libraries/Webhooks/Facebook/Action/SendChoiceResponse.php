<?php
namespace Roadbot\Libraries\Webhooks\Facebook\Action;

class SendChoiceResponse extends Interfaces\AbstractAction
{
    public function handleAction(array $data)
    {
        $md = "";
        $actionString = strtolower($data['action']);

        switch ($actionString) {
            case "hi-choice-items":
                $message = $this->conversations[$actionString];
//                $md = "hi-choice-items";
                break;
            default:
                $message = $this->conversations[$actionString];
        }

        return $this->httpClient->request('POST', $this->url, ['json' => $this->generateTextRequest($message, $data['userId'], $md)]);
    }

    private function generateTextRequest($text, $userId, $metadata)
    {
        $messageBody = $this->getRequestData($userId, $text, $metadata);
        error_log(json_encode($messageBody));
        return $messageBody;
        /*$request = new \GuzzleHttp\Psr7\Request(
                'POST',
                $this->url,
                ['json' => $messageBody]
            );*/

        //return $request;
    }


    protected function getRequestData($userId, $message, $metadata = '')
    {
        return $this->requestData = [
            'recipient' => ['id' => $userId],
            'message' => [
                'attachment' => [
                    "type" => "template",
                    "payload" => [
                        "template_type" => "generic",
                        "elements" => $message
                    ]
                ],
                'metadata' => $metadata]
        ];
    }
}


