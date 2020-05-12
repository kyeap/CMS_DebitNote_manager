
<div class="home_slogan_mobile"> <a href="#contact">
    Get your free consultation <s> (RM888) </s> now for RM0! 
    <div class="home_slogan_sub"> *For limited time only!* </div>
    <button class="home_promo_button"> Click Here! </button>
    </a>
</div>

<div class="home_slogan"> <a href="#contact"> Let me help you manage your risks! </a> </div>

<div class="home"> 
    <img src="../img/everst.png" class="home_content_left">
    <div class="home_content_right"> Ever dreamt to go to everst base camp? Run your first marathon? Well it's all about 
        risks management, financial planning and motivation. I finished my first marathon at the age of 53, peaked everst base camp at the 
    age of 61! I have been in the risk management business for more than 30years and have won countless awards helping both businesses and 
    individuals manage their risks. I know all about taking risks and planning your future. </div>
</div>

<img class="home_img" src="../img/everst.png">
<div class="home_content_mobile"> Ever dreamt to go to everst base camp? Run your first marathon? Well it's all about 
        risks management, financial planning and motivation. I finished my first marathon at the age of 53, peaked everst base camp at the 
    age of 61! I have been in the risk management business for more than 30years and have won countless awards helping both businesses and 
    individuals manage their risks. I know all about taking risks and planning your future.
 </div>



<div class="home_slogan"> <a href="#contact">
    Get your free consultation <s> (RM888) </s> now for RM0! 
    <div class="home_slogan_sub"> *For limited time only!* </div>
    <button class="home_promo_button"> Click Here! </button>
    </a>
</div>

<div class="contact">
    <form class="contact_form" id="contact" action="" method="post">
        <label class="formLabel" for="name">Name:</label>
        <input class="contact_input" type="text" name="name" required>
        <label class="formLabel" for="email">Email:</label>
        <input class="contact_input" type="email" name="email" required>
        <label class="formLabel" for="mobile">Contact No.:</label>
        <input class="contact_input" type="number" name="mobile" required>
        <label class="formLabel" for="msg">Message:</label>
        <textarea class="contact_input" type="text" name="msg" rows="10"> </textarea>
        <input class="contact_submit" type="submit" name="submit_contact" value="Set me free!">
    </form>
</div>

<script>
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("nav").style.top = "0";
  } else {
    document.getElementById("nav").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}
</script>

<?php



if ($_POST['submit'] = "submit_contact") {

    echo "contact form submmited"; 

    // the message
    $msg = "First line of text\nSecond line of text";

    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);

    // send email
    mail("sasanakenjoo@gmail.com","New Customer Request!",$msg);

}

?>