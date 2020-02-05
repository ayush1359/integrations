<?php
  $integrationname = "Capsule";
  $introdesc = "Make and receive calls directly on Capsule. And, automatically log all call activities, texts, call recordings and voicemails under your contacts and deals.";
  $pg = "capsule";
  $img = "assets/images/".$integrationname."/";
  $pgurl="capsule_landing_page";
  $video = "assets/video/capsule-demo.webm";
  $actual_link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
  $pass = $pg;
  $host = "justcall.io";
  
  setcookie("justcall_ref",$pass,time()+950000,"/",$host,null,true);

  //arveen
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Integrate Phone Calls and Texts with Capsule | JustCall Cloud Phone System</title>
    <link rel="icon" href="assets/images/favicon.png" sizes="16x16">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="verification" content="22b8761eed7a70352f5d7e0706e266e2" />
  
  <meta name=google-site-verification content=g2bJw92L4ubJacGcvsBkUMf8Jgaz43byWL5MD9vMjDk>
  <meta name=p:domain_verify content=c86573389cdd9dd6b4865d63fcd6d489>
  <meta name=google-site-verification content=nXuNPSVTM4NJ-FhE7pI-rcTjOQs2tHVtA65h82gNZOo />
  <meta http-equiv=Content-Type content="text/html; charset=utf-8"/>
  <meta name=viewport content="width=device-width, initial-scale=1.0">
  <meta name="description"
          content="Integrate your Phone calls and texts with Capsule. Make, receive and track calls direclty from Capsule."/>
  <meta name="keywords"
          content="capsule phone system, capsule track calls, capsule phone integration, capsule calling, call center system,desktop mobile,receive call online,cloud contact center software,call center phone system,cloud call center software,call center support software,phone systems for call centers,free call system,call from desktop,business phone software,desktop calling software,virtual phone number,virtual number,virtual phone system,virtual telephone number,virtual mobile number,voip number,localphone,voip phone,international calling,voip call,voip phone service,international phone number,virtual phone,international number,local number,free virtual number,voip phone number,call forwarding service,call center software,ivr system,forward calls ,call center solutions,call centre solutions,call center software solutions,call center solution provider,cloud call center solutions ,cloud based call center solutions,solution call center ,call center problems and solutions,call center phone,phone call identifier,how to transfer calls to cell phone,transfer phone calls,transfer calls to cell phone ,phone call center"/>
  <meta name=email content="help@justcall.io">
  <meta name=robots content="index,follow">

  <link rel='alternate' type='application/rss+xml' title='RSS' href='https://justcall.io/blog/feed/'>
  
  <link rel=image_src href="//assets/images/capsule/justcall-capsule-banner.png"/>
  <link rel=canonical href="<?php echo $actual_link; ?>"/>
  <link rel="shortcut icon" href="https://justcall.io/favicon.png">
  <meta property=og:title content="Integrate Phone Calls and Texts with Capsule | JustCall Cloud Phone System"/>
  <meta property=og:image content="//assets/images/capsule/justcall-capsule-banner.png"/>
  <meta property=og:type content=website />
  <meta property=og:url content="<?php echo $actual_link; ?>"/>
  <meta property=og:site_name content=JustCall />
  <meta http-equiv=PRAGMA content=PUBLIC>
  <meta http-equiv=Cache-control content=public>
  <meta name=Revisit-after content="1 Day">
  <meta property=fb:admins content=535410504 />
  <meta property=fb:app_id content=136737883478792 />
  <meta name=yandex-verification content=471bfe7f8a7b01f2 />
  <meta property=og:description content="Cloud-based phone system for small businesses. Instant setup - no hardware or deskphones. Get international phone numbers in 58 countries. Integrates with Zendesk, Intercom, Zoho and more."/>
  <meta name=author content=JustCall>
  
  <meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@justcall_io">
  <meta name="twitter:creator" content="@justcall_io">
  <meta name="twitter:title" content="Phone System for Capsule | JustCall.io">
  <meta name="twitter:description" content="Cloud-based phone system for small businesses. Instant setup - no hardware or deskphones. Get international phone numbers in 58 countries. Integrates with Zendesk, Intercom, Zoho and more.">
  <meta name="twitter:image" content="//assets/images/capsule/justcall-capsule-banner.png">
  
  <meta name="yandex-verification" content="f8f8ab6bed604554" />  
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans%7CRoboto:300,400,500%7CMontserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.css"> <!-- Resource style -->
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.theme.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/ionicons-2.0.1/css/ionicons.min.css"> <!-- Resource style -->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
    
    <style type="text/css">
    /*.hero-split .h-right{
      background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0)), url(assets/images/pipedrive/justcall-pipedrive-4.jpg) no-repeat center!important;
        -moz-transform: scale(1.05);
  -webkit-transform: scale(1.05);
  transform: scale(1.05);
    }*/


    .h-right {
          background: #f3f3f3 !important;
    }

    .features-image{
      box-shadow: 0px 0px 80px 0px rgba(0,0,0,.1);

    }
     .features-image:hover{
      box-shadow: 0px 0px 20px 0px rgba(0,0,0,.1);

    }

    .point-text {
      height: 90px !important;
      margin-bottom: 20px !important;
    }

    .step-1 {
    width: 100%;
    background: linear-gradient(to left, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0)), url(assets/images/capsule/justcall-capsule-banner.png) no-repeat center center;
    background-size: cover;
    padding: 150px 0 150px 0;
}

 .cta-big {
/*background: linear-gradient(to right, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.8)), url(assets/images/pipedrive/justcall-pipedrive-integration.png)  no-repeat center center;*/
background: linear-gradient(to left, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0)), url(assets/images/capsule/justcall-capsule-integrations.png) no-repeat center center;
  background-size: cover;
  padding: 150px 0 150px 0;
}   
::-webkit-input-placeholder { /* Chrome */
  color: #bfb5b5;
}

#justcall-calendar-widget{
  height: 650px !important;
}
    </style>
  </head>
  <body>

    <div class="wrapper">
      <?php include 'comon.php';?>
     <?php include 'navbar.php';?>
    

      <div id="main" class="main">
        <div class="hero-split" id="home" style="background: #f3f3f3;">
          <div class="h-right" style="margin-top: 22px; ">
            <video style="box-shadow: 1px 0 0 0px rgba(0,0,0,.06),0px -20px 70px rgba(0,0,0,.1) !important; object-fit: inherit;border-right: 45px solid; border-top: 45px solid; border-top-right-radius: 25px;background: #292929 " autoplay="" loop="" id="bgvid"  width="100%" height="100%">
              <source src="https://justcall.io/integrations/assets/video/pipedrive-demo.mp4"  type="video/mp4">
              
              Your browser does not support the video tag.
            </video>
          </div>
          <div class="h-left">
            <div class="left-content wow fadeInLeft" data-wow-delay="0s">
              <h2 class="wow fadeInLeft" data-wow-delay="0.1s">Integrate your phone calls with <span style="color: #2d95e5;"><?php echo $integrationname;?></span></h2>
              <p class="wow fadeInLeft" data-wow-delay="0.2s">
                <?php echo $introdesc;?>
              </p>
            <div class="form wow fadeInUp" data-wow-delay="0.3s">
                   <form class="subscribe-form wow zoomIn animated" action="https://justcall.io/signup.php?utm_source=<?php echo $pgurl;?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate=""  style="visibility: visible;">
                <input  style="padding-right: 20px;width: 220px ; border:1px solid #dcd4d4; height:39px;" id="pipedrive-email" class="mail" type="email" name="emailSignup" placeholder="Work Email" autocomplete="off" autofocus>

                <input  name="utm_source" value="<?php echo $pgurl;?>" type="hidden">
                <input class="submit-button" style="padding: 2px 25px 1px 25px; height: 41px;" type="submit" value="Get Started">
              </form>
                    <div class="success-message"></div>
                    <div class="error-message"></div>
                  </div>
              <p class="wow fadeInLeft" data-wow-delay="0.2s" style="margin-top:42px">
                🎊 JustCall is an official Capsule integration. Find us on <a href="https://marketplace.pipedrive.com/app/just-call/d401831fa27bdb38" rel="nofollow" target="_blank">Pipedrive Marketplace</a></p>
              <!-- <form>
              <div class="form-group">
                  
                  <input id="form_email" type="email" name="email" class="form-control" required="required" data-error="Valid email is required." placeholder="Work Email">
                  <div class="help-block with-errors"></div>
              </div>
              <div class="form-group">
                <a href="#contact" class="btn btn-action btn-nofill wow fadeInLeft" data-wow-delay="0.2s">Join JustCall</a>  
              </div>
              
              </form> -->
            </div>
          </div>
        </div>

<div id="services" class="pi-points">
          <div class="container">
            <div class="row text-center">
              <div class="col-sm-8 col-sm-offset-2">
              <div class="points-intro text-center">
                <h1 class="wow fadeInDown">Capsule Phone System Integration</h1>
              </div>
            </div>
              <div class="col-sm-4 wow fadeInDown featurediv" data-wow-delay="0.1s">
                <div class="point-icon">
                  <img src="assets/images/calls.svg" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Make calls from Capsule</h1>
                  <p>Making a call is as simple as clicking a button next to a phone number.</p>
                </div>
              </div>
              <div class="col-sm-4 wow fadeInDown featurediv" data-wow-delay="0.1s">
                <div class="point-icon">
                  <img src="assets/images/activities.svg" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Track your Activities</h1>
                  <p>View your daily interactions with customers and keep track of every activity that's important to your business.</p>
                </div>
              </div>
              <div class="col-sm-4 wow fadeInDown featurediv" data-wow-delay="0.2s">
                <div class="point-icon">
                  <img src="assets/images/recording.svg" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Access call recordings/voicemails</h1>
                  <p>JustCall records every call you make, ensuring a storage of each and every crucial detail of your customer.</p>
                </div>
              </div>
              <div class="col-sm-4 wow fadeInDown featurediv" data-wow-delay="0.2s">
                <div class="point-icon">
                  <img src="assets/images/contact-sync.svg" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Contact sync</h1>
                  <p>All your Capsule contacts are synced. You can be sure of never losing them.</p>
                </div>
              </div>
              <div class="col-sm-4 wow fadeInDown featurediv" data-wow-delay="0.2s">
                <div class="point-icon">
                  <img src="assets/images/messages.svg" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Click to text links</h1>
                  <p>Text message your people from Capsule.</p>
                </div>
              </div>
              <div class="col-sm-4 wow fadeInDown featurediv" data-wow-delay="0.2s">
                <div class="point-icon">
                  <img src="assets/images/missed-call.svg" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Missed Calls</h1>
                  <p>Get call back links whenever you miss a call from your people.</p>
                </div>
              </div>
             <!--  <div class="col-sm-4 wow fadeInDown" data-wow-delay="0.2s">
                <div class="point-icon">
                  <img src="assets/images/4.png" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Lorem Ipsum</h1>
                  <p>Lorem Ipsum and something that can look good here. Lorem Ipsum and something that can look good here.</p>
                </div>
              </div>
              <div class="col-sm-4 wow fadeInDown" data-wow-delay="0.3s">
                <div class="point-icon">
                  <img src="assets/images/5.png" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Lorem Ipsum</h1>
                  <p>Lorem Ipsum and something that can look good here. Now this block looks really great in a way I guess.</p>
                </div>
              </div>
              <div class="col-sm-4 wow fadeInDown" data-wow-delay="0.3s">
                <div class="point-icon">
                  <img src="assets/images/6.png" width="45" alt="Feature">
                </div>
                <div class="point-text">
                  <h1>Lorem Ipsum</h1>
                  <p>Lorem Ipsum and something that can look good here. Lorem Ipsum and something that can look good here.</p>
                </div>
              </div> -->
            </div>
          </div>
        </div>

        
        <div class="step-1">
          <div class="container">
            <div class="step-1-inner wow fadeInRight">
              <h4>Why you need JustCall?</h4>
              <h1>Integrate all your calling activities with Capsule</h1>
              <p>Get click to call and click to text buttons for your Capsule contacts. Make calls, receive calls, track missed calls, listen to voicemails and call recordings and also, send & receive text messages - from your Capsule dashboard!</p>
              <a href="https://justcall.io/calendar/techsupport?utm_source=<?php echo $pgurl;?>" class="btn btn-action btn-edge">Schedule a Free Demo</a>
            </div>
          </div>
        </div>
        <div id="features" class="features">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <div class="features-text wow fadeInDown">
                  <h2>Make calls from Capsule</h2>
                  <p>Call your people and organisations directly from Capsule. Get click to call buttons next to phone numbers on Capsule.</p>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="features-image wow fadeInRight">
                  <img class="img-responsive" src="assets/images/capsule/make-calls-from-capsule.png" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>

         <div id="features" class="features">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <div class="features-text wow fadeInDown">
                  <h2>Track all your calling and texting activities on Capsule</h2>
                  <p>JustCall creates activities on your Capsule account for every call you make or receive. Similar activities are created for inbound and outbound text messages.</p>
                </div>
              </div>
               <div class="col-sm-6">
                <div class="features-image wow fadeInLeft">
                  <img class="img-responsive" src="assets/images/capsule/justcall-capsule-activities.png" alt="">
                </div>
              </div>
              
            </div>
          </div>
        </div>

         <div id="features" class="features">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <div class="features-text wow fadeInDown">
                  <h2>Access call recordings and voicemails </h2>
                  <p>Listen to call recordings and voicemails in Capsule.</p>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="features-image wow fadeInRight">
                  <img class="img-responsive" src="assets/images/pipedrive/call-recordings.png" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="features" class="features">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <div class="features-text wow fadeInDown">
                  <h2>Text your Capsule customers and contacts </h2>
                  <p>With our click to text links against every phone number - you can send a message to your customer directly from Capsule</p>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="features-image wow fadeInRight">
                  <img class="img-responsive" src="assets/images/capsule/justcall-capsule-sendtexts.png" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- 
        <div id="pricing" class="pricing-section pricing-sm text-center">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="pricing-intro">
                  <h1 class="wow fadeInDown" data-wow-delay="0s">Our Pricing Plans.</h1>
                  <p class="wow fadeInDown" data-wow-delay="0.2s">
                    Our plans are designed to meet the requirements of both beginners <br class="hidden-xs"> and players.
                    Get the right plan that suits you.
                  </p>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="table-left wow fadeInDown" data-wow-delay="0.4s">

                      <div class="pricing-details">
                       <h2>Freemium</h2>
                       <span>Free</span>
                          <ul>
                            <li>First basic feature </li>
                            <li>Second feature goes here</li>
                            <li>Any other third feature</li>
                          </ul>
                        <button class="btn btn-primary btn-action btn-edge" type="button">Get Plan</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="table-right table-center wow fadeInDown" data-wow-delay="0.6s">

                      <div class="pricing-details">
                        <h2>Beginner</h2>
                        <span>$19.99</span>
                        <ul>
                          <li>First premium feature </li>
                          <li>Second premium one goes here</li>
                          <li>Third premium feature here</li>
                        </ul>
                        <button class="btn btn-primary btn-action btn-edge" type="button">Buy Now</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="table-right wow fadeInDown" data-wow-delay="0.6s">

                      <div class="pricing-details">
                       <h2>Premium</h2>
                       <span>$19.99</span>
                       <ul>
                         <li>First premium feature </li>
                         <li>Second premium one goes here</li>
                         <li>Third premium feature here</li>
                       </ul>
                       <button class="btn btn-primary btn-action btn-edge" type="button">Buy Now</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->

       
         <?php include 'takemetohelp.php';?>
<?php include 'otherfeatures.php';?>


        <!--<?php //include 'signupform.php';?>-->
        <!--<div class="text-center" style="background-color:#2d95e5; color:white; margin-bottom: 30px;" >
          <h1 style="font-size:30px;padding-top:15px; padding-bottom:15px;font-weight: 600;color: white;"><?php echo $integrationname;?>+Justcall = More Sales</h1>

        </div>-->
        <?php include 'otherintegrations.php';?>

        <div class="text-center" style="margin-bottom:20px;">
          <!-- <h2>Schedule Demo For <?php echo $integrationname; ?> Telephony Integration</h2> -->

        <div id="justcall-calendar-widget" data-link="https://justcall.io/demo"></div><script type="text/javascript" src="https://justcall.io/widget.js" onload="justcall.init()" async></script>
      </div>


        <div class="text-center" style="margin-top:20px; margin-bottom:20px;">
        <a href="https://justcall.io/signup?utm_source=<?php echo $pgurl;?>"><button type="button" class="btn" style="; background-color:#f95120; font-size:24px; color:white; padding:10px 40px;">Get started in 30 seconds</button></a>
      </div>
<?php include 'footer.php';?>
        

        <!-- Scroll To Top -->

          <a id="back-top" class="back-to-top page-scroll" href="#main">
          <i class="ion-ios-arrow-up"></i>
          </a>

        <!-- Scroll To Top Ends-->

      </div> <!-- Main -->
      <?php include 'footersection.php';?>
    </div><!-- Wrapper -->


  <!-- Jquery and Js Plugins -->
  <script type="text/javascript" src="assets/js/jquery-2.1.1.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/plugins.js"></script>
  <script type="text/javascript" src="assets/js/validator.js"></script>
  <script type="text/javascript" src="assets/js/contact.js"></script>
  <script type="text/javascript" src="assets/js/custom.js"></script>
</body>
</html>
