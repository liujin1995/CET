<?php

$key='-----BEGIN PUBLIC KEY----- 
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAMFBIs6VqyyxytxiY6sHocThOKoJWNSY8BuKXMilvKUsdagv44zFJvMXnV2E7ZbdjpNS1IY/uRoJzwUuob3sme0CAwEAAQ==
-----END PUBLIC KEY-----';
$encryptedData ="1,508070161101411,韩竞";
// $decrypted = base64_decode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, urldecode('o3RLqifEZ5UWyA1Vre9aSVr6QyfOmWpIrfX6OytVnCGDfSdp0m8VmYYjanKwALShYy1s%252FwXebhCEb%252BJaRtGO4g%253D%253D'), MCRYPT_MODE_CBC));
$pu_key = openssl_pkey_get_public($key);
openssl_public_encrypt($encryptedData,$encrypted,$pu_key);//公钥加密  
$a=urlencode(base64_encode($encrypted));
echo $data="tp=1&czn={$a}&v=8fcw";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://cache.neea.edu.cn/query.html");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 9_3_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Mobile/13G34 -SuperFriday_7.4.0','Referer: http://chaxun.neea.edu.cn/query/query_cet.html','Cookie: Hm_lvt_dc1d69ab90346d48ee02f18510292577=1471513157,1471513824,1471518406,1471604831; Hm_lpvt_dc1d69ab90346d48ee02f18510292577=1471604831'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_exec($ch);
echo strlen($data);