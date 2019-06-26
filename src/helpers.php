<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use AceLords\Core\Repositories\RedisRepository;
use Illuminate\Support\Facades\Artisan;

if (! function_exists('adjustBrightness'))
{
    function adjustBrightness($hex, $steps) 
    { 
        // Steps should be between -255 and 255. Negative = darker, positive = lighter 
        $steps = max(-255, min(255, $steps)); 
        // Normalize into a six character long hex string 
        $hex = str_replace('#', '', $hex); 
        if (strlen($hex) == 3) { 
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2); 
        } 
        // Split into three parts: R, G and B 
        $color_parts = str_split($hex, 2); 
        $return = '#';
        foreach ($color_parts as $color) { 
            $color = hexdec($color); // Convert to decimal 
            $color = max(0,min(255,$color + $steps)); // Adjust color 
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code 
        } 
        return $return;
    }
}


if (! function_exists('core_paginate'))
{
    /**
     * Get paginations for different parts of the System.
     * Opted for function in case the paginations require to be
     * retrieved via a setting instead of config option.
     * 'xs' => 5,
     * 's' => 10,
     * 'm' => 25,
     * 'l' => 50,
     * 'xl' => 100,
     * 'p' => 7
     *
     * @param string $entity
     * @return int $pagination
     */
    function core_paginate($entity = "p") {
        $paginations = config('acelords_core.pagination');
        foreach($paginations as $key => $value) {
            if ($key == strtolower($entity))
                return (int)$value;
        }
        return (int)$paginations['p'];
    }
}

if (!function_exists('ddd'))
{

    /**
     * add to the default dd()
     * to return 500 response code for ajax error detection
     */
    function ddd(...$vars)
    {
        http_response_code(500);

        foreach ($vars as $v) {
            \Symfony\Component\VarDumper\VarDumper::dump($v);
        }

        die(1);
    }
}


if(!function_exists('doe'))
{
    /*
     * Returns a list of the countries in the system
     */
    function doe()
    {
        if(request()->ajax())
        {
            return auth()->guard('api')->user();
        }

        return auth()->user();
    }
}


if(! function_exists("eclair"))
{
    /*
     * Prepares a date for a more user ready format
     */
    function eclair($date, $time = true, $toW3cString = false)
    {
        if(!$date)
            return null;

        if($toW3cString)
            return Carbon::parse($date)->toW3cString();

        if($time) {
            return Carbon::parse($date)->format("M d, Y h:i:s a");
        }

        return Carbon::parse($date)->format("M d, Y");
    }
}



if(! function_exists('sanitizeDomainUrl'))
{
    /**
     * Sanitize URL
     *
     * @var string
     * @return string
     */
    function sanitizeDomainUrl(string $str = "") : string
    {
        empty($str) ? $str = request()->root() : null;

        // $input = 'www.google.co.uk/';
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $str = trim($str, '/');

        // If scheme not included, prepend it
        if (! preg_match('#^http(s)?://#', $str)) {
            $str = 'http://' . $str;
        }

        $urlParts = parse_url($str);

        // remove www
        $domain = preg_replace('/^www\./', '', $urlParts['host']);

        // output: google.co.uk
        return $domain;
    }
}

if(! function_exists('_is_curl_installed'))
{
    /**
     * check if curl is installed on the server
     *
     * @return bool
     */
    function _is_curl_installed() {
        if  (in_array  ('curl', get_loaded_extensions())) {
            return true;
        }
        else {
            return false;
        }
    }
}

if (! function_exists('redis'))
{
    /*
     * Return an instance of our custom redis repository
     */
    function redis()
    {
        return resolve(RedisRepository::class);
    }
}


if (! function_exists('dd_blade_variables'))
{
    /**
     * dd all variables passed to blade
     * Does not work here: only in blade files
     */
    function dd_blade_variables()
    {
        dd(get_defined_vars()['__data']);
    }
}


if(! function_exists('is_serialized'))
{
    /**
     * check if is serialized or not.
     * Borrowed from WordPress
     */
    function is_serialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (! is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (! preg_match('/^([adObis]):/', $data, $badions))
            return false;
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                    return true;
                break;
        }

        return false;
    }
}


if (! function_exists('sanitizeBladeUrl'))
{
    /**
     * sanitize blade url
     *
     * @param string $url
     * @param string $realBaseUrl
     *
     * @return string
     */
    function sanitizeBladeUrl(string $url, string $realBaseUrl) : string
    {
        $str = "";
        
        // remove 'localhost' from the $realBaseUrl
        if(str_contains($url, 'localhost')) {
            $urlParts = collect(explode('localhost', $url))->slice(1);
            $str = $realBaseUrl . implode('/', $urlParts->toArray());
        }
    
        if(str_contains($url, request()->root())) {
            $urlParts = collect(explode(request()->root(), $url))->slice(1);
            $str = $realBaseUrl . implode('/', $urlParts->toArray());
        }
    
        return $str;
    }
}


if(! function_exists("relativeUrl"))
{
    /**
    * Formats an absolute url to a relative url; strip the root domain from the url
    */
    function relativeUrl($url)
    {
        return str_replace(request()->root(), '', $url);
    }
}


if (!function_exists('is_countable')) {
    
    /**
     * a polyfill for the php 7.3 function
     */
    function is_countable($c) {
        return is_array($c) || $c instanceof \Countable;
    }
}

if (!function_exists('filenameSanitizer')) {
    
    /** 
    * filename sanitizer
    *
    * @var mixed Request
    */
    function filenameSanitizer($str) {
        $nicename = str_replace(' ', '-', strtolower($str));
        // Remove anything which isn't a word, whitespace, number,
        // or any of the following characters -_~,;[]().
        // if you don't need to handle multi-byte characters
        // you can use preg_replace rather than mb_ereg_replace
        $nicename = preg_replace('([^\w\s\d\-_~,;\[\]\(\).])', '', $nicename);
        // remove any runs of periods
        $nicename = preg_replace('([\.]{2,})', '', $nicename);

        return $nicename;
    }
}



if(! function_exists('command_exists'))
{
    /**
     * Check if an artisan command exists
     *
     * @param $name
     *
     * @return bool
     */
    function command_exists($name)
    {
        return array_has(Artisan::all(), $name);
    }
}


if (!function_exists('setting'))
{
    /**
     * Retrieve a setting configuration value.
     * no need in prefixing the module's name since they are unique
     *
     * @param $setting
     * @param string|null $default
     *
     * @return mixed
     */
    function setting($setting, $default = null)
    {
        return redis()->get('configurations')->where('name', $setting)->first()->value ?? $default;
    }
}
