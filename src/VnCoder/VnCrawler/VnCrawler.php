<?php

namespace VnCoder\VnCrawler;

/**
 * VnCrawler.php
 *
 * @author      Cuong Pham <me@s2vnn.com>
 * @date        28/11/2015
 * @reference   http://simplehtmldom.sourceforge.net/manual.htm
 */

class VnCrawler {


    /*
     * Read Website Content
     */

    static function dom($url = '' , $fields = [] , $option = []){
        $html = self::get($url , $fields , $option);
        if($html){
            return self::str_get_html($html);
        }

        return false;
    }



    /**
     * @return mixed
     */
    static public function file_get_html()
    {
        return call_user_func_array('\file_get_html', func_get_args());
    }

    /**
     * @return mixed
     */
    static public function str_get_html()
    {
        return call_user_func_array('\str_get_html', func_get_args());
    }
	

    /*
     * Get Crawler
     */

    static function get($url = '', $fields = [], $option = [])
    {
        $ch = curl_init();
        if (isset($option['header'])) {
            if ($option['header'] == 'json') {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
            }
        }
        if (isset($option['mobile']) && $option['mobile']) {
            $user_agent = 'Mozilla/5.0 (Linux; Android 5.0.1; SM-N910F Build/LRX22C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36'; // GalaxyJ Docomo - Android 5
        } else {
            $user_agent = 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0'; // Firefox 42
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

        $cookie_file = isset($option['cookie']) ? $option['cookie'] : 'cookie.txt';
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8,gzip,deflate'); // Get Content Utf-8
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $referer = isset($option['referer']) ? $option['referer'] : self::get_domain($url);
        curl_setopt($ch, CURLOPT_REFERER, $referer);

        if (is_array($fields) && $fields) {
            $fields_string = '';
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');

            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        }

        $content = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode == 200 ? $content : false;
    }

    static function get_domain($url = '')
    {
        if (!$url) return 'https://www.google.com/';
        $host = @parse_url($url, PHP_URL_HOST);
        if (!$host) $host = $url;
        if (substr($host, 0, 4) == "www.") $host = substr($host, 4);
        return $host;
    }
	
} 