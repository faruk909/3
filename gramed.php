<?php
error_reporting(0);
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

function save($filename, $email)
{
    $save = fopen($filename, "a");
    fputs($save, "$email");
    fclose($save);
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

function getnumber()
{
    $url = "https://smshub.org/stubs/handler_api.php?api_key=125578U6f2961ed06eb15907cba02101eb74f0c&action=getNumber&service=ot&operator=&country=6";
    $headers = array();
    $getotp = request1($url, $headers);
    $subif = substr($getotp, 0, 13);
    if ($subif == "ACCESS_NUMBER") {
        $jumlah = strlen($getotp);
        $subnomor = $jumlah - 23;
        $nomor = substr($getotp, 24, $subnomor);
        $sub = substr($getotp, 14, 9);
        return array($nomor, $sub, true);
    } else {
        echo "Gagal mendapatkan nomor \n";
    }
}

function ambilotp($id)
{
    $url = "https://smshub.org/stubs/handler_api.php?api_key=125578U6f2961ed06eb15907cba02101eb74f0c&action=getStatus&id=$id";
    $headers = array();
    $getotp = request1($url, $headers);
    $subif = substr($getotp, 0, 9);
    if ($subif == "STATUS_OK") {
        $regex = "/\d\d\d\d\d\d/";
        preg_match($regex, $getotp, $hasil);
        $kode = $hasil[0];
        echo "Berhasil ambil OTP: $kode\n";
        return array($kode, true);
    } else {
    }
}

function ambilotp2($id)
{
    $url = "https://smshub.org/stubs/handler_api.php?api_key=125578U6f2961ed06eb15907cba02101eb74f0c&action=getStatus&id=$id";
    $headers = array();
    $getotp = request1($url, $headers);
    $subif = substr($getotp, 0, 9);
    if ($subif == "STATUS_OK") {
        $sub = substr($getotp, 10, 5);
        echo "Berhasil ambil OTP: $sub\n";
        return array($sub, true);
    } else {
    }
}
function retryotp($id)
{
    $url = "https://smshub.org/stubs/handler_api.php?api_key=125578U6f2961ed06eb15907cba02101eb74f0c&action=setStatus&status=3&id=$id";
    $headers = array();
    $getotp = request1($url, $headers);
    $subif = substr($getotp, 0, 16);
    if ($subif == "ACCESS_RETRY_GET") {
        return true;
    } else {
    }
}

function suksesotp($id)
{
    $url = "https://smshub.org/stubs/handler_api.php?api_key=125578U6f2961ed06eb15907cba02101eb74f0c&action=setStatus&status=6&id=$id";
    $headers = array();
    $getotp = request1($url, $headers);
    $subif = substr($getotp, 0, 16);
    if ($subif == "ACCESS_RETRY_GET") {
        return true;
    } else {
    }
}

function cancleotp($id)
{
    $url = "https://smshub.org/stubs/handler_api.php?api_key=125578U6f2961ed06eb15907cba02101eb74f0c&action=setStatus&status=8&id=$id";
    $headers = array();
    $getotp = request1($url, $headers);
    $subif = substr($getotp, 0, 16);
    if ($subif == "ACCESS_RETRY_GET") {
        return true;
    } else {
    }
}

function regis($email, $nomor, $fname, $lname)
{
    $url = "https://auth.myvalue.id/v1/user/";
    $data = '{"email":"' . $email . '","password":"viola331","mobilePhoneNumber":"+' . $nomor . '","mobilePhonePrefix":"+62","firstName":"' . $fname . '","lastName":"' . $lname . '","clientID":"MyValueWeb","redirect_uri":"https://www.myvalue.id/redirect","outletID":"10111","additional":{"email_only":"true"}}';
    $headers = array();
    $headers[] = "Host: auth.myvalue.id";
    $headers[] = "Cookie: G_ENABLED_IDPS=google; client=%7B%22client_id%22%3A%22MyValueWeb%22%2C%22redirect_uri%22%3A%22https%3A%2F%2Fwww.myvalue.id%2Fredirect%22%2C%22back%22%3A%22undefined%22%2C%22state%22%3A%22eNjUv67yihvE0%22%2C%22isThirdParty%22%3Afalse%7D";
    $headers[] = 'Accept: application/json, text/plain, */*';
    $headers[] = "Content-Type: application/json";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36";
    $headers[] = "Origin: https://auth.myvalue.id";
    $headers[] = "Accept-Encoding: gzip, deflate";
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $getotp = request($url, $data, $headers);
    $json = json_decode($getotp, true);
    $a = $json['enabled'];
    if ($a == true) {
        $kgid = $json['kgValueID'];
        $phone = $json['phone'];
        $email = $json['email'];
        $fname = $json['firstName'];
        $lname = $json['lastName'];
        $result = "berhasil register ==> $fname $lname | $email | $phone | $kgid \n";
        return array($result, true);
    } else {
        echo "gagal register";
    }
}

function otp($nomor)
{
    $url = "https://auth.myvalue.id/v1/verification/send/";
    $data = '{"username":"' . $nomor . '","template":""}';
    $headers = array();
    $headers[] = "Host: auth.myvalue.id";
    $headers[] = "Cookie: G_ENABLED_IDPS=google; client=%7B%22client_id%22%3A%22MyValueWeb%22%2C%22redirect_uri%22%3A%22https%3A%2F%2Fwww.myvalue.id%2Fredirect%22%2C%22back%22%3A%22undefined%22%2C%22state%22%3A%22eNjUv67yihvE0%22%2C%22isThirdParty%22%3Afalse%7D";
    $headers[] = 'Accept: application/json, text/plain, */*';
    $headers[] = "Content-Type: application/json";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36";
    $headers[] = "Origin: https://auth.myvalue.id";
    $headers[] = "Accept-Encoding: gzip, deflate";
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $getotp = request($url, $data, $headers);
    $json = json_decode($getotp, true);
    echo "suskes kirim otp \n";
}

function inputotp($nomor, $token)
{
    $url = "https://auth.myvalue.id/v1/verification/check/";
    $data = '{"username":"' . $nomor . '","token":"' . $token . '"}';
    $headers = array();
    $headers[] = "Host: auth.myvalue.id";
    $headers[] = "Cookie: G_ENABLED_IDPS=google; client=%7B%22client_id%22%3A%22MyValueWeb%22%2C%22redirect_uri%22%3A%22https%3A%2F%2Fwww.myvalue.id%2Fredirect%22%2C%22back%22%3A%22undefined%22%2C%22state%22%3A%22eNjUv67yihvE0%22%2C%22isThirdParty%22%3Afalse%7D";
    $headers[] = 'Accept: application/json, text/plain, */*';
    $headers[] = "Content-Type: application/json";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36";
    $headers[] = "Origin: https://auth.myvalue.id";
    $headers[] = "Accept-Encoding: gzip, deflate";
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $getotp = request($url, $data, $headers);
    $json = json_decode($getotp, true);
    $valid = $json['valid'];
    if ($valid == true) {
        return true;
    }
}

function datareg()
{
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
    return array($anama, $bnama, $mail2);
}

$total = 1;
$ulangotp = 0;
echo "MAU BRP: ";
$brp = trim(fgets(STDIN));

ulang:
if ($total <= $brp) {
    $data = datareg();
    $fname = $data[0];
    $lname = $data[1];
    $email = $data[2];
    $ambilnomor = getnumber();
    if ($ambilnomor[2] == true) {
        $nomor = $ambilnomor[0];
        $id = $ambilnomor[1];
        echo "Berhasil ambil nomor == $nomor \n";
        $regis = regis($email, $nomor, $fname, $lname);
        if ($regis == true) {
            echo $regis[0]; //menampilkan result berhasil
            otp($nomor);
            echo "Menunggu otp masuk \n";
            ulangotp:
            if ($ulangotp <= 10) {
                $otp = ambilotp($id);
                if ($otp[1] == true) {
                    $token = $otp[0];
                    $inputotp = inputotp($nomor, $token);
                    if ($inputotp == true) {
                        save("result.txt", $regis[0]);
                        echo "Berhasil create dan verify \n";
                        echo "\n";
                        $ulangotp = 0;
                        $total = $total + 1;
                        suksesotp($id);
                        goto ulang;
                    } else {
                        echo "Gagal veriv otp \n";
                        goto ulang;
                    }
                } else {
                    sleep(5);
                    echo "Tidak berhasil dapet otp \n";
                    $ulangotp = $ulangotp + 1;
                    goto ulangotp;
                }
            } else {
                $ulangotp = 0;
                $id = $ambilnomor[1];
                cancleotp($id);
                goto ulang;
            }
        } else {
            echo "gagal regis \n";
            $id = $ambilnomor[1];
            cancleotp($id);
            goto ulang;
        }
    } else {
        echo "gagal ambil nomor \n";
        goto ulang;
    }
} else {
    echo "berhasil bikin semua akun \n";
}
