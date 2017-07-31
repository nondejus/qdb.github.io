<?php

namespace Quantico;

class Qurl extends Qai
{
    protected static function query($url, $ref, $data=false, $type=false)
    {
        if(is_array($data))
        { 
            $data = json_encode($data); 
            $http = array('Content-Type:application/json'); 
        }
        else
        {
            if($type) $data = 'url='.$type; else $data = 'text='.urlencode($data); 
            $http = array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'); 
        }
        
        $ch = curl_init($url);
        
        curl_setopt_array($ch,
            array(
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36 OPR/42.0.2393.94',
                CURLOPT_REFERER => $ref,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => $http
            )
        );
        
        $out = curl_exec($ch);
        curl_close($ch);
        
        return $out;
    }
}

?>
