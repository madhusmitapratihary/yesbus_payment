
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" CONTENT="noindex,nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Error</title>
    <style>
        body{
            font-family: 'Work Sans', sans-serif;
            background: #00d2ff; 
            background: -webkit-linear-gradient(to right, #3a7bd5, #00d2ff); 
            background: linear-gradient(to right, #B6BAC9, #808080); 
        }
        h1 {
          color: #ea3323;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 30px;
          margin: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          text-align:center;
          margin-bottom: 10px;
        }
        
      i {
        color: red;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: #dbdce0;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 2px 10px 40px black;
        display: inline-block;
        margin: 7% auto;
      }
      .redirect{
        margin-top: 25px;
        font-size: 20px;
        /* font-weight: 600; */
      }
      .redirect span{
        color: rgb(46, 49, 136);
        font-weight: 700;
      }
      .checkmark_upper_div{
        border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;
      }
      @media (max-width: 600px){
        .card{padding: 15px;margin: 12% auto;width: 90%;}
        .checkmark_upper_div{
            height: 120px;
            width: 120px;
        }
        .checkmark{
            font-size: 67px;
            line-height: 130px;
            margin-left: -11px;
        }
        h1{
            font-size: 23px;
            margin-top: 20px;
        }
        p{
            font-size: 14px;
        }
        .redirect{
            font-size: 15px;
        }
      }
    </style>
</head>
<body>
    <section class="payment_sec">
        <div class="container text-center">
            <div class="card">
                <div class="checkmark_upper_div">
                    <i class="checkmark">!</i>
                </div>
                <h1>Payment Session Expired</h1> 
                <p>We apologize for the inconvenience, but it seems that your payment session has expired.<br/></p>
                <p>Payment sessions typically have a limited duration to ensure the security of your transaction. To proceed with your payment, please return to the seat book page and start a new transaction. </p>
                <p>Thank you for choosing our service, and we appreciate your understanding.</p>
            </div>
        </div>
    </section>
</body>
</html>