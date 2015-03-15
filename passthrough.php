<?php

/* 
 * The MIT License
 *
 * Copyright 2015 Mitchfizz05.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Handles passthrough requests.
 * Acts essentially as a proxy to the Realms API.
 * **This does not forward status codes!
 * 
 * Mostly a modified version of http://stackoverflow.com/a/2138534
 */

require_once 'inc/Realms.php';
Realms::init();

$requestpath = '/' . $_GET['path'];
$url = Realms::$config->get('debug', 'passthrough_url') . $requestpath;

$fields = $_POST;

echo '<b>URL</b>: ' . $url . '<br>';
echo '<b>Request Path:</b> ' . $requestpath . '<br>';
echo '<b>Fields:</b> ' . print_r($fields, true) . '<br>';
echo '<b>Query string:</b> ' . $_SERVER['QUERY_STRING'];

$postvars='';
$sep='';
foreach($fields as $key => $value) {
    $postvars .= $sep.urlencode($key) . '=' . urlencode($value);
    $sep='&';
}

echo $postvars;
exit;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Host' => Realms::$config->get('debug', 'passthrough_vhost')
));

$result = curl_exec($ch);

$httpresponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpresponse != 0) {
    http_response_code($httpresponse); // Send status code received from Minecraft Realms backend.
} else {
    http_response_code(502); // 502 Bad Gateway - failed to connect to Minecraft Realms backend.
    echo 'something went wrong. :(';
    exit;
}

curl_close($ch);

echo $result;

