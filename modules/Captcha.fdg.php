<?php
/**
* Easy implementation of the Google Captcha.
*/

class FDG_Captcha{
  public function __construct($fdg) {
    $this->FinlayDaG33k = $fdg;
  }

  /**
  * Add the captcha Javascript to the document
  * This should be placed in the <head> tag of the site
  *
  * @param string $siteKey The sitekey to access the Google Captcha resources
  * @param string $onComplete Javascript code on what to do when the Captcha has been completed
  */
  public function initCaptcha($siteKey,$onComplete = ""){
    ?>
      <script type="text/javascript" src='https://www.google.com/recaptcha/api.js?onload=fdg_reCaptchaCallback&render=explicit'></script>

      <script>
        function fdg_reCaptchaCallback() {
          grecaptcha.render('fdg_captcha', {
            'sitekey': '<?= htmlentities($siteKey); ?>',
            'callback': fdg_reCaptchaVerify,
            'expired-callback': fdg_reCaptchaExpired
          });
        }

        function fdg_reCaptchaVerify(response) {
          if (response === document.querySelector('.g-recaptcha-response').value) {
            <?php $onComplete; ?>
          }
        }

        function fdg_reCaptchaExpired() {
          grecaptcha.reset(); // reset the captcha
        }
      </script>
    <?php
  }

  /**
  * Add a <div> tag to the document for the Captcha to be loaded in
  */
  public function displayCaptcha(){
    ?>
      <div id="fdg_captcha"></div>
    <?php
    return true;
  }

  /**
  * Verify a captcha
  *
  * @param $siteSecret The $siteSecret to access the Google Captcha resources
  * @return bool The validity of the captcha
  */
  public function verifyCaptcha($siteSecret){
    if(!empty($_POST['g-recaptcha-response'])){
      $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$siteSecret."&response=".$_POST['g-recaptcha-response']);
      $responseKeys = json_decode($response,true);
      if(intval($responseKeys["success"]) == 1) {
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
}
