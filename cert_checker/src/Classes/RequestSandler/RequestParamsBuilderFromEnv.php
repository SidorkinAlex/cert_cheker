<?php

namespace Sidalex\CertChecker\Classes\RequestSandler;

class RequestParamsBuilderFromEnv
{
    public static function possibleBuild(array $env): bool
    {

        if (isset($env['REQUEST_URI']) && self::isValidURI($env['REQUEST_URI'])) {
            return true;
        }
        return false;
    }

    static function isValidURI($uri): bool
    {

        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP
        $regex .= "(\:[0-9]{2,5})?"; // Port
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor

        if (preg_match("/^$regex$/i", $uri)) // `i` flag for case-insensitive
        {
            return true;
        }
        return false;
    }

    public static function buildRequestParams(array $env): RequestParams
    {
        $url = '';
        $headers = [];
        if (isset($env['REQUEST_URI']) && self::isValidURI($env['REQUEST_URI'])) {
            $url = $env['REQUEST_URI'];
        }
        $headers = self::buildRequestHeaders($env['REQUEST_HEADER']);
        return new RequestParams($url, $headers);
    }


    private static function buildRequestHeaders($REQUEST_HEADER): array
    {
        if (!is_null($REQUEST_HEADER)) {
            $rh = json_decode($REQUEST_HEADER);
            if ($rh !== false && array_is_list($rh)) {
                return $rh;
            }
        }
        return [];
    }

}