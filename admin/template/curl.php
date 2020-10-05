<?php
    function getData($url,$token,$postData)
    {
        $ch = curl_init();
        $header = array();
        // $header[] = 'Content-Type: application/json';
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'X-Requested-With: XMLHttpRequest';
        $header[] = 'Authorization: Bearer '.$token;

        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);

        if($postData != NULL)
        {
            curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($postData));
        }

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        return ($server_output);
    }
    
    
    