<?php
    if(isset($_GET['initialize_payment'])){
        if($_GET['domain_name']!=''){
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "http://localhost:2000/api/booking/payment/initialize/".$_GET['initialize_payment'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'domain' => $_GET['domain_name']
                ]),
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer abc",
                    "YESBUS_API_KEY: BusAgentIndia",
                    "accept: application/json"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "<script> location.href='http://localhost/YB/payment/payment-failed.php?bookingError=".$err."'; </script>";
            } else {
                $responseData = json_decode($response,true);
                if($responseData['status']==200){
                    session_start();
                    $expirationTime = time() + 300; // 300 seconds = 5 minutes
                    $domainDataArray = $responseData['data'];
                    $_SESSION["site_name"] = $domainDataArray['domain_name'];
                    $_SESSION["site_url"] = $domainDataArray['site_url'];
                    $domainDataArray['expiration_time'] = $expirationTime;
                    $serializedData = serialize($domainDataArray);
                    setcookie('payment_cookies', $serializedData, $expirationTime, '/');
                    echo "<script> location.href='http://localhost/YB/payment/payment.php'; </script>";
                }else{
                    echo "<script> location.href='http://localhost/YB/payment/payment-failed.php?bookingError=".$responseData['message']."'; </script>";
                }
                die();
            }
        }
    }

    /* $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "http://localhost:2000/api/booking/payment/initialize/abc235t5t56dgdg=dvf==",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'domain' => 'yesbus.in'
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer abc",
            "YESBUS_API_KEY: yesbusapi",
            "accept: application/json"
        ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "<script> location.href='payment-failed.php?bookingError=".$err."'; </script>";
    } else {
        $responseData = json_decode($response,true);
        echo "<pre>";
        print_r($responseData['data']);
        echo "</pre>";
        exit;
        if($responseData['status']==200){
            echo "<script> location.href='http://localhost/YB/payment/payment.php'; </script>";
        }else{
            echo "<script> location.href='http://localhost/YB/payment/payment-failed.php?bookingError=".$responseData['message']."'; </script>";
        }
        die();
    } */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" CONTENT="noindex,nofollow">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Payment Processing</title>
        <style>
            body{
                font-family: 'Work Sans', sans-serif;
                background: #fff; 
            }
            .card {
                background: #fff;
                padding: 60px;
                display: inline-block;
                margin: 7% auto;
                border:none;
            }
            .redirect{
                margin-top: 25px;
                font-size: 20px;
            }
            .redirect span{
                color: rgb(46, 49, 136);
                font-weight: 700;
            }
        </style>
    </head>
    <body>
        <section class="payment_sec">
            <div class="container text-center">
                <div class="card">
                    <div style="border-radius:200px; height:200px; width:200px; margin:0 auto;">
                        <img src="https://dbtdacfw.gov.in/Images/progress.gif" alt="">
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>