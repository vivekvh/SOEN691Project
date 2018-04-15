<?php

ini_set('max_execution_time', 2500); //300 seconds = 5 minutes

// Github REST API example
function github_request($url)
{
    $ch = curl_init();
    
    // Basic Authentication with token
    // https://developer.github.com/v3/auth/
    // https://github.com/blog/1509-personal-api-tokens
    // https://github.com/settings/tokens
    $access = 'vivekvh:871e51653901860fbcc30f3119dd024d16ce0062';
    
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
    curl_setopt($ch, CURLOPT_USERAGENT, 'Agent smith');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERPWD, $access);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    $result = json_decode(trim($output), true);
    return $result;
}
  $file = 'comments.txt';
$current = file_get_contents($file);

for($i = 1;$i<=1269;$i++ ) {
$commits = github_request('https://api.github.com/repos/wordpress/wordpress/commits?page='.$i);
//$commits = json_encode($commits,JSON_PRETTY_PRINT);
foreach($commits as $item) { //foreach element in $arr
//    $uses = $item["commit"]["message"]; //etc
    $commitdate = $item["commit"]["committer"]["date"];
    $commitdate = explode("T",$commitdate);
    $uses = str_replace(array("\r", "\n"), '', $uses);
    $sha = $item["sha"];
    $write = $sha."||".$commitdate[0]."\n";
    $current .= $write;
//    echo("<p>");
//    print($commitdate[0]);
//    echo("</p>");
    file_put_contents($file, $current);
}
}
?>
<pre>
    <?php
//print_r($commits);
?>
</pre> <?php



// Open the file to get existing content

// Append a new person to the file

// Write the contents back to the file










////$events = github_request('https://api.github.com/users/:username/events?page=1&per_page=5');
//$events = github_request('https://api.github.com/users/:username/events/public?page=1&per_page=5');
////print_r($events);
//$feeds = github_request('https://api.github.com/feeds/:username?page=1&per_page=5');
////print_r($feeds);
//$repos = github_request('https://api.github.com/user/repos?page=1&per_page=100');
//print_r($repos);  

?>