<?php
error_reporting(0);

function save($filename, $email)
{
    $save = fopen($filename, "a");
    fputs($save, "$email");
    fclose($save);
}

function request1($url, $headers, $put = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($put) :
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    endif;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($headers) :
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    endif;
    curl_setopt($ch, CURLOPT_ENCODING, "GZIP");
    return curl_exec($ch);
}

function request($url, $data, $headers, $put = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($put) :
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    endif;
    if ($data) :
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    endif;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($headers) :
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    endif;
    curl_setopt($ch, CURLOPT_ENCODING, "GZIP");
    return curl_exec($ch);
}

function regis($email, $nope, $fname, $lname, $jmlh)
{
    $url = "https://auth.myvalue.id/v1/user/";
    $data = '{"email":"' . $email . '","password":"gramedia123","mobilePhoneNumber":"' . $nope . '","mobilePhonePrefix":"+62","firstName":"' . $fname . '","lastName":"' . $lname . '","clientID":"MyValueWeb","redirect_uri":"https://www.myvalue.id/redirect","outletID":"10111"}';
    $headers = array();
    $headers[] = "Host: auth.myvalue.id";
    $headers[] = "Cookie: client=%7B%22client_id%22%3A%22MyValueWeb%22%2C%22redirect_uri%22%3A%22https%3A%2F%2Fwww.myvalue.id%2Fredirect%22%2C%22state%22%3A%22eNjUv67yihvE0%22%2C%22isThirdParty%22%3Afalse%7D; G_ENABLED_IDPS=google; auth_token=%7B%22access_token%22%3A%22tRumn_EEUWJM61aivf4LROP3K5C6HMzNWfT4CNlZc9s.SNtkkqGmF38hHxwfO6N9VJboVCn-P-L2rW67vEan_QA%22%2C%22refresh_token%22%3A%22uLm1FDw7t68-DKpVBgkbaAMNw4xh41KcgIAQQhVQwr0.5lffLG_CRgVcrkXeXA5rSDvBzTCu0ji3OOp4IC3gNIQ%22%2C%22token_type%22%3A%22bearer%22%2C%22expires_in%22%3A86400%2C%22refresh_expires_in%22%3A31622400%2C%22id_token%22%3A%22%22%2C%22not_before_policy%22%3A0%2C%22session_state%22%3A%22%22%2C%22expired%22%3A1657452756298%7D";
    $headers[] = 'Sec-Ch-Ua: ".Not/A)Brand";v="99", "Google Chrome";v="103", "Chromium";v="103"';
    $headers[] = "Accept: application/json, text/plain, */*";
    $headers[] = "Content-Type: application/json";
    $headers[] = "Sec-Ch-Ua-Mobile: ?0";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36";
    $headers[] = 'Sec-Ch-Ua-Platform: "Windows"';
    $headers[] = "Origin: https://auth.myvalue.id";
    $headers[] = "Accept-Encoding: gzip, deflate";
    $headers[] = "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
    $getotp = request($url, $data, $headers);
    $json = json_decode($getotp, true);
    $a = $json['enabled'];
    if ($a == true) {
        $kgid = $json['kgValueID'];
        $result = "$fname $lname | $nope | $kgid \n";
        save("result.txt", $result);
        echo "$jmlh. BERHASIL => $result";
    } else {
        echo "gagal";
    }

    //var_dump($json);
}

function nope()
{
    $nope1 = rand(0, 9);
    $nope2 = rand(0, 9);
    $nope3 = rand(0, 9);
    $nope4 = rand(0, 9);
    $nope5 = rand(0, 9);
    $nope6 = rand(0, 9);
    $nope7 = rand(0, 9);
    $nope8 = rand(0, 9);
    $nope9 = rand(0, 9);
    $nope = "+6281$nope1$nope2$nope3$nope4$nope5$nope6$nope7$nope8$nope9";
    return $nope;
}


echo "Mau Buat Akun brp: ";
$brp = trim(fgets(STDIN));

for ($i = 0; $i < $brp; $i++) {
    $fgcnama = file_get_contents("bahannama.txt");
    $hslnama = explode("\n", str_replace("\r", "", $fgcnama));
    $count = count($hslnama);

    $b = rand(0, 99);
    $anama = $hslnama[rand(0, $count)];
    $bnama = $hslnama[rand(0, $count)];
    $fullnama = "$anama $bnama";
    $hsl2 = str_replace(" ", "", $fullnama);
    $sub = substr($hsl2, 0, 15);
    $kcl  = strtolower($sub);
    $kcl2 = "$kcl";
    $mail2 = "$kcl2$b@gmail.com";
    $nope = nope();
    regis($mail2, $nope, $anama, $bnama, $i);
    sleep(10);
}
