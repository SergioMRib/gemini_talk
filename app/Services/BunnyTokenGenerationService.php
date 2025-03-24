<?php

namespace App\Services;

use Carbon\Carbon;


class BunnyTokenGenerationService
{
    /*
		url: CDN URL w/o the trailing '/' - exp. http://test.b-cdn.net/file.png
		securityKey: Security token found in your pull zone
		expirationTime: Authentication validity (default. 86400 sec/24 hrs)
		userIp: Optional parameter if you have the User IP feature enabled
		isDirectory: Optional parameter - "true" returns a URL separated by forward slashes (exp. (domain)/bcdn_token=...)
		pathAllowed: Directory to authenticate (exp. /path/to/images)
		countriesAllowed: List of countries allowed (exp. CA, US, TH)
		countriesBlocked: List of countries blocked (exp. CA, US, TH)
	*/

    protected string $baseUrl;
    protected string $securityKey;

    public function __construct() {
        $this->baseUrl = config('filesystems.bunny-storage.pull-zone-url');
        $this->securityKey = config('filesystems.bunny-storage.security-key');
    }

    public function generateSignedUrl($url, $securityKey, $expirationTime) {

        $signedUrl = "the url signed will be here";

        return $signedUrl;
    }

    function sign_bcdn_url($url, $securityKey, $expiration_time = 3600, $user_ip = NULL, $is_directory_token = false, $path_allowed = NULL, $countries_allowed = NULL, $countries_blocked = NULL, $referers_allowed = NULL)
    {
         /*
         * This code was obtained at https://github.com/BunnyWay/BunnyCDN.TokenAuthentication/blob/master/php/url_signing.php
         *
         */

        $url = $this->baseUrl . $url; //while the name says url it is the file path
        $securityKey = $this->securityKey;

        if(!is_null($countries_allowed))
        {
            $url .= (parse_url($url, PHP_URL_QUERY) == "") ? "?" : "&";
            $url .= "token_countries={$countries_allowed}";
        }
        if(!is_null($countries_blocked))
        {
            $url .= (parse_url($url, PHP_URL_QUERY) == "") ? "?" : "&";
            $url .= "token_countries_blocked={$countries_blocked}";
        }
        if(!is_null($referers_allowed))
        {
            $url .= (parse_url($url, PHP_URL_QUERY) == "") ? "?" : "&";
            $url .= "token_referer={$referers_allowed}";
        }

        $url_scheme = parse_url($url, PHP_URL_SCHEME);
        $url_host = parse_url($url, PHP_URL_HOST);
        $url_path = parse_url($url, PHP_URL_PATH);
        $url_query = parse_url($url, PHP_URL_QUERY);


        $parameters = array();
        parse_str($url_query, $parameters);

        // Check if the path is specified and ovewrite the default
        $signature_path = $url_path;

        if(!is_null($path_allowed))
        {
            $signature_path = $path_allowed;
            $parameters["token_path"] = $signature_path;
        }

        // Expiration time
        $expires = Carbon::now()->addSeconds($expiration_time)->timestamp;

        // Construct the parameter data
        ksort($parameters); // Sort alphabetically, very important
        $parameter_data = "";
        $parameter_data_url = "";
        if(sizeof($parameters) > 0)
        {
            foreach ($parameters as $key => $value)
            {
                if(strlen($parameter_data) > 0)
                    $parameter_data .= "&";

                $parameter_data_url .= "&";

                $parameter_data .= "{$key}=" . $value;
                $parameter_data_url .= "{$key}=" . urlencode($value); // URL encode everything but slashes for the URL data
            }
        }

        // Generate the toke
        $hashableBase = $securityKey.$signature_path.$expires;

        // If using IP validation
        if(!is_null($user_ip))
        {
            $hashableBase .= $user_ip;
        }

        $hashableBase .= $parameter_data;

        // Generate the token
        $token = hash('sha256', $hashableBase, true);
        $token = base64_encode($token);
        $token = strtr($token, '+/', '-_');
        $token = str_replace('=', '', $token);

        if($is_directory_token)
        {
            return "{$url_scheme}://{$url_host}/bcdn_token={$token}&expires={$expires}{$parameter_data_url}{$url_path}";
        }
        else
        {
            return "{$url_scheme}://{$url_host}{$url_path}?token={$token}{$parameter_data_url}&expires={$expires}";
        }
    }
}

