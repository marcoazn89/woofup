<?php
namespace Roadbot\Libraries\Webhooks\Facebook\Action;

class SendTextResponse extends Interfaces\AbstractAction
{
    public function handleAction(array $data)
    {
        $message = "";
        $md = "";
        $actionString = strtolower($data['action']);

        switch ($actionString) {

            // HI
            case "hi":
                $message = $this->conversations[$actionString];
                $md = "text.hi-echo";
                break;
            case "hi-echo":
                $message = $this->conversations[$actionString];
                $md = "choice.hi-choice-items";
                break;

            // LOOKING
            case "looking":
                $message = $this->conversations[$actionString];
//                $md = "text.totalparkdays";
                break;

            // LEAVING
            case "leaving":
                $message = $this->conversations[$actionString];
                $md = "text.leaving-next";
                break;
            case "leaving-next":
                $message = $this->conversations[$actionString];
                $md = "text.leaving-desc";
                break;
            case "leaving-desc":
                $message = $this->conversations[$actionString];
                $md = "text.leaving-desc-next";
                break;
            case "leaving-desc-next":
                $message = $this->conversations[$actionString];
                break;

            // SUBMIT SPOT
            case "submit-spot":
                $message = $this->conversations[$actionString];
                $md = "image.submit-spot";

                break;
            case "spot-pic-sent":
                $message = $this->conversations[$actionString];
                $md = "text.spot-begin-sent";
                break;
            case "spot-begin-sent":
                $message = $this->conversations[$actionString];
                $md = "text.spot-end-sent";
                break;
            case "spot-end-sent":
                $message = $this->conversations[$actionString];
                $md = "text.spot-end-next";
                break;
            case "spot-end-next":
                $message = $this->conversations[$actionString];
                break;

            case "totalparkdays":

                $message = $this->conversations[$actionString];
                //$this->repository->storeDay();
                break;
            case "endparktime":
                $message = $this->conversations[$actionString];
                $md = "image.searchspot";
                break;
            case "searchspot":
                $message = $this->conversations[$actionString];
                $md = "text.isparking";
                break;
            case "isparking":
                $message = $this->conversations[$actionString];
                break;
            case "parknow":
                $message = $this->conversations[$actionString];
                $md = "text.spotfound";
                // waiting logic or search logic?
                break;
            case "spotresultsuccess":
                $message = $this->conversations[$actionString];
                break;
            case "spotresultfail":
                $message = $this->conversations[$actionString];
                $md = "text.spotresultfail-next";
                break;
            case "spotresultfail-next":
                $message = $this->conversations[$actionString];
                break;
            case "browsing":
                $message = $this->conversations[$actionString];
                break;
            case "choosespot":
                $message = $this->conversations[$actionString];
                break;
            case "rejectspot":
                $message = $this->conversations[$actionString];
                break;
            case "findspot":
                $message = $this->conversations[$actionString];
                break;
            case "spotfound":
                $message = $this->conversations[$actionString];
                $md = "text.spotfound-next";
                break;
            case "spotfound-next":
                $message = $this->conversations[$actionString];
                $md = "text.spotfound-reminder";
                break;
            case "lostspot":
                $message = $this->conversations[$actionString];
                break;
            case "no":
                $message = $this->conversations[$actionString];
                break;
            default:
                $message = $this->conversations['unknown'];
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
}
