<?php
namespace Roadbot\Libraries\Webhooks\Facebook\Action;

class SendImageAction extends Interfaces\AbstractAction
{
    /**
     * Handles actions
     *
     * @param  array $data Data to be processed
     * @return array       Data to be sent
     */
    public function handleAction(array $data)
    {
        $actionString = strtolower($data['action']);
        $imageData = "";

        $step1Gif = $this->getMessage("https://storage.googleapis.com/roadbot-bucket/rb-step1-gif.gif");
        $step2Gif = $this->getMessage("https://storage.googleapis.com/roadbot-bucket/rb-step2-gif.gif");
        $step3Gif = $this->getMessage("https://storage.googleapis.com/roadbot-bucket/rb-step3-gif.gif");

        switch ($actionString) {
            case "submit-spot":

                // STEP 3
                $imageData = $this->getRequestData($data['userId'], $step3Gif);
                // STEP 1
                $imageData2 = $this->getRequestData($data['userId'], $step1Gif);
                $this->httpClient->request('POST', $this->url, ['Content-Type' => 'application/json; charset=utf-8', 'json' => $imageData2]);

                // STEP 2
                $imageData3 = $this->getRequestData($data['userId'], $step2Gif);
                $this->httpClient->request('POST', $this->url, ['Content-Type' => 'application/json; charset=utf-8', 'json' => $imageData3]);
                break;
            default:
                break;

        }

        return $this->httpClient->request('POST', $this->url, ['Content-Type' => 'application/json; charset=utf-8', 'json' => $imageData]);
    }

    public function getMessage($url)
    {
        return [
            'attachment' => [
                'type' => 'image',
                'payload' => [
                    'url' => $url
                ]
            ]
        ];
    }

    protected function getRequestData($userId, $message, $metadata = '')
    {
        return $this->requestData = [
            'recipient' => ['id' => $userId],
            'message' => $message,
            'metadata' => $metadata
        ];
    }
}
