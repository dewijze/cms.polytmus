<div id="widthcontainer" class="animated fadeInRight0 block box">

    <div id="contact-outer">
    
        <div id="sidetext">

            <?php  pluginText('contact');   ?>

        </div>

        <div id="contact">
            


                <form id="contactform" action="./plugins/contact/processForm.php" method="post" class="animated zoomIn">
                    <div id="contactinner">
                    
                        <input type="email" id="mail" name="mail" placeholder=' Email' class="nope"/>
                        <div class="wide"><div class="wide"><input type="text" id="name" name="name" placeholder=' Name' class="right"/></div></div>
                        <div class="wide"><div class="wide"><input type="text" id="email" name="email" placeholder=' Email' class="right"/></div></div>
                        <div class="wide"><div class="wide"><input type="text" id="phone" name="phone" placeholder=' Phone' class="right"/></div></div>
                        <div class="wide"><div class="wide"><textarea id="message" name="message" rows="5" cols="20" placeholder=' Message' class="right"></textarea></div></div>
                        
                        <input type="submit" value="Send!" id="send" />
                    </div>
                    
                    
                </form>
                <div id="response"></div>
                <div class="full-hr"></div>

          
        </div>
    </div>

<div class="box-bottom"></div>
</div>
    
