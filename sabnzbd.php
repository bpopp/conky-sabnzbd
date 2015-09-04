<?php
$hostname="192.168.1.6";
$port = "8080";
$user = "bpopp";
$pass = "password";
$api='yourkeygoeshere';

$url  = sprintf ( "http://%s:%s/sabnzbd/api?mode=queue&start=0&limit=5&output=xml&addid&ma_username=%s&ma_password=%s&apikey=%s",
            $hostname,
            $port,
            $user,
            $pass,
            $api );
                        
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);

if ( ! $data = curl_exec($curl) )
{
  echo curl_error($curl);  
}

curl_close($curl);

$xml = new SimpleXMLElement($data);

$result = $xml->xpath('slots/slot');
if ( !sizeof ( $result ) )
    echo "No downloads.";

while(list( , $node) = each($result))
{
    //echo "test";
    echo sprintf ( "%-23s\ \${goto 220}%s \${alignr}%s%%\n",  substr ( $node->filename, 0, 23 ),$node->size,$node->percentage );
}

