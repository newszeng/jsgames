<?php
ini_set("display_errors",true);
error_reporting(E_ALL);

function get_google_translation($tl, $sl, $q ,$retry=0 ) {
    $googlemethod = 0;
    $qstr = '';
    $iqstr = '';
    if (is_array($q)) {
        foreach ($q as $v) {
            $qstr .= '&q=' . $v;
            $iqstr .= urldecode($v);
        }
    } else {
        $qstr = '&q=' . $q;
        $iqstr = urldecode($q);
    }
    // we avoid curling we had all results prehand
    $urls = array(
        'http://translate.google.com',
        'http://74.125.195.138',
        'https://translate.googleapis.com');

//    var_dump($qstr);exit;

    $attempt = 1;
    $failed = true;
    foreach ($urls as $gurl) {
        if ($googlemethod < $attempt && $failed) {
            $failed = false;

            $url = $gurl . '/translate_a/t?client=te&v=1.0&tl=' . $tl . '&sl=' . $sl . '&tk=' . iq($iqstr, '406448.272554134');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //must set agent for google to respond with utf-8
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $qstr);
            // timeout is probably a good idea
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_TIMEOUT, 7);

            //if the attempt is 2 or more, we skip ipv6 and use an alternative user agent
            if ($attempt > 1) {
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                //curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36");
            }

            $output = curl_exec($ch);
            $info = curl_getinfo($ch);

            curl_close($ch);

            sleep(2);

            if ($info['http_code'] != 200) {

                $failed = true;

            }
            unset($info);
        }
        $attempt++;
    }
    // weird output that happens - $output='[[[[["Nnọọ"]],,"en"],[[["ụwa"]],,"en"],[[["Kedu ihe na-eme"]],,"en"]]]';
    
    
    $jsonarr = json_decode($output);
    if (!$jsonarr) {

        $newout = str_replace(',,', ',', $output);

        $jsonarr = json_decode($newout);
        if (!$jsonarr) {

            return false;
        }
    }

    if (is_array($jsonarr)) {
        if (is_array($jsonarr[0])) {
            foreach ($jsonarr as $val) {
                // need to drill
                while (is_array($val)) {
                    $val = $val[0];
                }
                $result[] = $val;
            }
        } else {
            // 如果是简单数组（如 ["你好","世界","你好吗？"]），返回所有元素
            $result = $jsonarr;
        }
    } else {
        $result[] = $jsonarr;
    }

    //header('Content-type: text/html; charset=utf-8');
    if(!$result && $retry<5){
        $retry++;
        return get_google_translation($tl, $sl, $q ,$retry);
    }
    return $result;
}


function _bitwise_zfrs($a, $b) {
    if ($b == 0)
        return $a;
    return ($a >> $b) & ~(1 << (8 * PHP_INT_SIZE - 1) >> ($b - 1));
}

function hq($a, $chunk) {
    for ($offset = 0; $offset < strlen($chunk) - 2; $offset += 3) {
        $b = $chunk[$offset + 2];
        $b = ($b >= "a") ? ord($b) - 87 : intval($b);
        $b = ($chunk[$offset + 1] == "+") ? _bitwise_zfrs($a, $b) : $a << $b;
        $a = ($chunk[$offset] == "+") ? $a + $b & 4294967295 : $a ^ $b;
    }
    return $a;
}

function iq($input, $error) {
    $e = explode(".", $error);
    $value = intval($e[0]);
    for ($i = 0; $i < strlen($input); $i++) {
        $value += ord($input[$i]);
        $value = hq($value, "+-a^+6");
    }
    $value = hq($value, "+-3^+b+-f");
    $value ^= intval($e[1]);
    if (0 > $value) {
        $value = $value & 2147483647 + 2147483648;
    }
    $x = $value % 1E6;
    return $x . "." . ($x ^ intval($e[0]));
}
