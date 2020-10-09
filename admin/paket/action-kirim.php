<?php
    session_start();
    include('../../config.php');
    $url = api_url()."/api/v1/tracking/send";
    $ch = curl_init();
    $header = array();
    $postData = array('target_id'=>$_POST['target_id']);
    // $header[] = 'Content-Type: application/json';
    $header[] = 'Content-Type: application/x-www-form-urlencoded';
    $header[] = 'X-Requested-With: XMLHttpRequest';
    $header[] = 'Authorization: Bearer '.$_SESSION['access_token'];

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
    
    echo ($server_output);
    
    