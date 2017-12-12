<?php
class FDG_Captcha{
  private $modVersion = "0.1a";

  public static function initCaptcha($siteKey,$onComplete = ""){
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

  public static function displayCaptcha(){
    ?>
      <div id="fdg_captcha"></div>
    <?php
    return true;
  }

  public static function verifyCaptcha($siteSecret){
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
