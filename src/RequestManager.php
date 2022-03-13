<?php
#
# WebPlug
# https://webplugin.tk
#
# (c) liamgen.js
#
# For the full license information, view the LICENSE.md file that was distributed with this source code.
#

namespace http;
class RequestManager{

    public static function post($url, array $post, array $options)
    {
        $ch = curl_init($url);
        
        foreach ($options as $key => $val) {
            curl_setopt($ch, $key, $val);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        $errno    = curl_errno($ch);
        
        if (is_resource($ch)) {
            curl_close($ch);
        }

        if (0 !== $errno) {
            throw new RuntimeException($error, $errno);
        }
        
        return $response;
    }
}