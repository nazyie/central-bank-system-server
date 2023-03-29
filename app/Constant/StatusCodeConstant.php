<?php

namespace App\Constant;

class StatusCodeConstant {
    // !informational response 100 - 199
    // !successful response 200 - 299
    const OK = '200';
    const CREATED = '201';

    // !redirection message 300 - 399
    // !client error 400 - 499
    const BAD_REQUEST = '400';
    const UNAUTHORIZED = '401';
    const FORBIDDEN = '403';
    const METHOD_NOT_ALLOWED = '405';
    const NOT_FOUND = '404';

    // !server error response 500 - 599
    const INTERNAL_SERVER_ERROR = '500';
}