<?php
    ob_start();
    
    $cookieArray = array();
    $remainingTime = 0;
    if (isset($_COOKIE['payment_cookies'])) {
        // Cookie exists, you can access it
        $paymentCookies = $_COOKIE['payment_cookies'];
        $cookieArray = unserialize($paymentCookies);
        if (time() <= (int)$cookieArray['expiration_time']) {
            $remainingTime = (int)$cookieArray['expiration_time'] - time();
        }
    } else {
        echo "<script> location.href='https://payment.busagents.co.in/payment-expired.php'; </script>";
    }
    //exit;
    
    if(isset($_POST['paynow'])){
        // for testing
        /* $mKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $dataArray = array(
            "merchantId" => "PGTESTPAYUAT",
            "merchantTransactionId" => !empty($cookieArray) ? base64_decode($cookieArray['secure_code']): '',
            "merchantUserId" => "MUID123",
            "amount" => !empty($cookieArray) ? $cookieArray['amount_to_pay']*100 : '',
            // "redirectUrl" => "https://payment.busagents.co.in/",
            // "redirectUrl" => "https://payment.busagents.co.insuccess.php",
            "redirectUrl" => "https://payment.busagents.co.in/paymentprocess.php",
            "redirectMode" => "POST",
            "callbackUrl" => "https://payment.busagents.co.in/paymentprocess.php",
            "mobileNumber" => !empty($cookieArray) ? $cookieArray['contact_details']['mobile'] : '',
            "paymentInstrument" => array(
                "type" => "PAY_PAGE"
            )
        ); */
        // for live
        $mKey = 'c010796c-53f9-43bf-8e89-ef1e8b09c34d';
        $dataArray = array(
            "merchantId" => "YESBUSONLINE",
            "merchantTransactionId" => !empty($cookieArray) ? base64_decode($cookieArray['secure_code']): '',
            "merchantUserId" => "MUID123",
            "amount" => !empty($cookieArray) ? $cookieArray['amount_to_pay']*100 : '',
            // "redirectUrl" => "https://payment.busagents.co.in/",
            // "redirectUrl" => "https://payment.busagents.co.insuccess.php",
            "redirectUrl" => "https://payment.busagents.co.in/paymentprocess.php",
            "redirectMode" => "POST",
            "callbackUrl" => "https://payment.busagents.co.in/paymentprocess.php",
            "mobileNumber" => !empty($cookieArray) ? $cookieArray['contact_details']['mobile'] : '',
            "paymentInstrument" => array(
                "type" => "PAY_PAGE"
            )
        );
        $payloadmain = base64_encode(json_encode($dataArray));
        $payload = $payloadmain."/pg/v1/pay".$mKey;
        $makHas = hash('sha256',$payload);
        $makHas = $makHas.'###1';
        $curl = curl_init();

        curl_setopt_array($curl, [
            // CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
            CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'request' => $payloadmain
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-VERIFY: ".$makHas,
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        /* echo "<pre>";
        print_r($response);
        echo "</pre>";
        exit; */
        if ($err) {
            //echo "cURL Error #:" . $err;
            echo "<script> location.href='https://payment.busagents.co.in/payment-failed.php?bookingError=".$err."'; </script>";
        } else {
            $responseData = json_decode($response,true);
            $url = $responseData['data']['instrumentResponse']['redirectInfo']['url'];
            echo "<script> location.href='".$url."'; </script>";
            //header('Location: '.$url);
            die();
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" CONTENT="noindex,nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        /* If you like this, please check my blog at codedgar.com.ve */
        @import url('https://fonts.googleapis.com/css?family=Work+Sans');
        body{
            font-family: 'Work Sans', sans-serif;
            background: #00d2ff; 
            background: -webkit-linear-gradient(to right, #3a7bd5, #00d2ff); 
            background: linear-gradient(to right, #B6BAC9, #808080); 
        }

        .card {
            background: #dbdce0;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 2px 10px 40px black;
            display: inline-block;
            margin: 7% auto;
            padding-bottom: 20px;
        }
        .ribbon {
            position: absolute;
            left: -7px;
            top: -7px;
            z-index: 1;
            overflow: hidden;
            width: 188px;
            height: 159px;
            text-align: right;
        }
        .ribbon span {
            font-size: 14px;
            font-weight: bold;
            color: #FFF;
            text-transform: uppercase;
            text-align: center;
            line-height: 30px;
            transform: rotate(45deg);
            -webkit-transform: rotate(317deg);
            width: 211px;
            height: 31px;
            display: block;
            background: #79A70A;
            background: linear-gradient(#5658ad 0%, #2f3183 100%);
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 40px;
            right: 20px;
        }
        .ribbon span::before {
            content: "";
            position: absolute; left: 0px; top: 100%;
            z-index: -1;
            border-left: 8px solid #4e4d4d;
            border-right: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-top: 8px solid #4e4d4d;
        }
        .ribbon span::after {
            content: "";
            position: absolute; right: 0px; top: 100%;
            z-index: -1;
            border-left: 8px solid transparent;
            border-right: 8px solid #4e4d4d;
            border-bottom: 8px solid transparent;
            border-top: 8px solid #4e4d4d;
        }
        .back_div{
            position: absolute;
            text-align: right;
            top: 19px;
            right: 17px;
        }
        .back_div button{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgb(46, 49, 136);
            border: none;
            color: white;
            transition: box-shadow .2s, transform .4s;
        }
        .sendicontwo {
            -webkit-transform: rotate(180deg);
            filter: invert(100%);
            padding-top: 2px;
        }
        .pay-sec {
            margin-top: 40px;
        }
        .pay-sec button {
            background: #2f3183;
            color: #fff;
            border: #fff;
            padding: 5px 16px;
            font-size: 18px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .logo_div{
            margin-bottom: 35px;
        }
        .logo_div img{
            width: 200px;
        }
        .comprobe{
            margin-top: 46px;
        }
        .cost {
            color: #2f3183;
            font-weight: 600;
        }
        #countdown{
            font-size: 18px;
            font-weight: 600;
            width: 85px;
            text-align: left;
        }
        @media (max-width: 600px){
            .card{padding: 40px;margin: 12% auto;width: 90%;}
            .logo_div img{
                width: 130px;
            }
            .comprobe{
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <section class="payment_sec">
        <div class="container text-center">
            <div class="card">
                <div class="ribbon"><span><?=!empty($cookieArray) ? $cookieArray['domain_name'] : '' ?></span></div>
                <form method="POST">
                    <div class="payment-main-div">
                        <div class="back_div">
                            <button class="proceed" type="button" onclick="window.location.href='<?=!empty($cookieArray) ? $cookieArray['site_url'] : '' ?>'">
                                <svg class="sendicon sendicontwo" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="logo_div">
                            <img src="<?=!empty($cookieArray) ? $cookieArray['logo'] : '' ?>" alt="">
                        </div>
                        <div class="payment-details-div">
                            <p><?=!empty($cookieArray) ? $cookieArray['contact_details']['name'] : '' ?></p>
                            <p><?=!empty($cookieArray) ? $cookieArray['contact_details']['mobile'] : '' ?></p>
                            <p><?=!empty($cookieArray) ? $cookieArray['contact_details']['email'] : '' ?></p>
                            <div class="payment-mobile-div">
                                <h2 class="cost">₹<?=!empty($cookieArray) ? number_format($cookieArray['amount_to_pay'],2) : '' ?>
                                    <!-- <span style="font-size:20px">.34</span> -->
                                </h2>
                            </div>
                            <div class="pay-sec">
                                <button type="submit" name="paynow">Pay Now</button>
                            </div>
                            <div class="bottom-sec">
                                <p class="comprobe"><i class="fa fa-info-circle" aria-hidden="true" style="color: #2f3183;"></i> This information will be sent to your email</p>
                                <p class="text-danger">This Payment Session is expires in : <label id="countdown"></label></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
    <script>
        
        function updateRemainingTime() {
        const remainingTimeElement = document.getElementById('countdown');
        let remainingTime = <?php echo $remainingTime; ?>;

        const intervalId = setInterval(function () {
            if (remainingTime <= 1) {
                clearInterval(intervalId);
                var redirectUrl = 'https://payment.busagents.co.in/payment-expired.php';
                window.location.href = redirectUrl;
            } else {
                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;

                // Format the timer as "Xm Ys"
                remainingTimeElement.innerHTML = `${minutes}m ${seconds}s`;

                remainingTime--; // Decrement remainingTime by 1 second
            }
        }, 1000); // Run every 1000 milliseconds (1 second)
    }
    updateRemainingTime();
       
    </script>
</body>
</html>
