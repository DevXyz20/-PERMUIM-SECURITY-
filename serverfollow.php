<?php

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAccountsByFollowers($minFollowers, $maxFollowers) {
    // عنوان URL  للـ API
    $url = 'https://api.tiktok.com/accounts'; // استبدله بعنوان API الفعلي إذا كان متاحًا
    
    $data = array(
        'min_followers' => $minFollowers,
        'max_followers' => $maxFollowers
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_GET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: TikTok/1.0 (compatible; Xyz/1.0; +http://tiktok[csrftoken].com)',
        'Content-Type: application/json'
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

$minFollowers = 50000; // الحد الأدنى من المتابعين
$maxFollowers = 1000000; // الحد الأقصى من المتابعين

// عدد الحسابات التي سيتم استرجاعها
$numberOfAccounts = 200;
$responses = [];

// استخراج الحسابات
for ($i = 0; $i < $numberOfAccounts; $i++) {
    $responses[] = getAccountsByFollowers($minFollowers, $maxFollowers);
}

// عرض الاستجابات في تنسيق JSON
header('Content-Type: application/json');
echo json_encode($responses);

?>
