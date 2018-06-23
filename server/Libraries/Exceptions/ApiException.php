<?php
namespace Roadbot\Libraries\Exceptions;

use Exception\BooBoo;

class ApiException extends BooBoo
{
    public const INTERNAL_ERROR = 'Internal error';
    public const MISSING_PARAMS = 'One or more parameters are missing in the request. Please check your request and try again';
    public const INCORRECT_PARAMS = 'One or more parameters recieved were incorrect. Please, try again';
    public const INVALID_CALL = 'Invalid API call. Please review the API documentation';
    public const BAD_CREDENTIALS = 'Unable to verify credentials';
    public const FORBIDDEN = 'Access denied';
    public const TOO_MANY = 'Request blocked. Too many API calls received. Please try again later';
    public const NO_TEXT = 'No text was found in the document during parsing';
    public const RESOURCE_NOT_FOUND = 'Resource not found';
    public const MAX_POST_SIE = 'The request is too large to be processed';
    public const CONFLICT = 'Resource already exists';

    protected function getTag()
    {
        return 'ApiException';
    }
}
