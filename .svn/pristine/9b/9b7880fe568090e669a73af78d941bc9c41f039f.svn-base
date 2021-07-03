<!--bottom html-->
<div class="container_bottom">
    <div class="bottom_center">
        <div class="bottom_center_left">
        <p><img src="<?php echo get_template_directory_uri() ;?>/images/adds.png"><span id="xload-footer-add" data-file="<?php echo v1_get_template_directory_uri(); ?>/nosvg/ajax/14b2beb717e0f5dd" data-scroll="false"></span>
<script>$(function () { $("#xload-footer-add").xload(); });</script></p>
                <p><img src="<?php echo get_template_directory_uri() ;?>/images/tel.png"><span id="xload-f2" data-file="<?php echo v1_get_template_directory_uri(); ?>/nosvg/ajax/14b2beb717e0f5d4" data-scroll="false"></span>
<script>$(function () { $("#xload-f2").xload(); });</script></p>
                <p><img src="<?php echo get_template_directory_uri() ;?>/images/fax.png"><span id="xload-footer-fax" data-file="<?php echo v1_get_template_directory_uri(); ?>/nosvg/ajax/14b2beb717e0f5df" data-scroll="false"></span>
<script>$(function () { $("#xload-footer-fax").xload(); });</script></p>
                <p><img src="<?php echo get_template_directory_uri() ;?>/images/email.png">Email: <span id="xload-footer-email" data-file="<?php echo v1_get_template_directory_uri(); ?>/nosvg/ajax/14b2beb717e0f5de" data-scroll="false"></span>
<script>$(function () { $("#xload-footer-email").xload(); });</script></p>
        </div>
        <div class="bottom_center_left">
            <h4>Subscribe</h4>
            <form >
                <div style="padding-bottom: 1em;padding-right: 0.5em;color: #fff;">Enter your email here to subscribe.</div>
                <div ><label style="color: #fff;">Email *</label></div>
                <div style="padding-bottom: 10px;">
                    <input type="email"  name="email" value="" maxlength="40" required="" id="txt_email" style="border: 1px solid #fff;color: #fff;height: 36px;line-height: 36px;width: 80%;outline-style: none;padding-left: 10px;margin-top: 10px;background-color: #164982;" >
                </div>
                <div style="padding-top: 10px;padding-bottom: 5px;color: #fff;">
                    <button type="button"  onclick="subscribe();"  name="button" style="cursor:pointer;display: inline-block;height: 40px;clear: both;color: #fff;text-decoration: none;background-color: #f39801;text-align: center;width: 30%;border: 0;">Subscribe</button>
                </div>
            </form>
        </div>
        <div class="bottom_center_left">
        <?php dynamic_sidebar('footerbar-3');?>
        </div>
        <div class="bottom_center_left">
        <?php dynamic_sidebar('footerbar-4');?>
        </div>
    </div>
    <div class="bottom_cop">Copyright © 2007 - <?php echo date('Y'); ?> <?php echo v1_get_option( array('type'=>'copyright')) ?>. All Rights Reserved.</div>
</div>
<script>

    function  subscribe() {
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo CustomConfig::RECAPTCHAHTML;?>', {action: 'submit'}).then(function(token) {
                var email=$('#txt_email').val();
                email=email.replace(/(^\s*)|(\s*$)/g, "");
                if (email==''){

                }else {
                    var itemdata={action:'userSubscribe',email:email,grecaptcharesponse:token}
                    $.ajax({
                        url: "<?php echo admin_url( 'admin-ajax.php' )?>",
                        data: itemdata,
                        type: "post",
                        datatype: "json",
                        async: true,
                        beforeSend: function (XMLHttpRequest) {
                        },
                        success: function (data, textStatus, jqXHR) {

                            if (data=='1'){
                                $('#txt_email').val('')
                                alert('Subscription is successful!');
                            }else {
                                alert('Subscription is fail!');
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            alert('Subscription is fail!');
                        }
                    });
                }

            });
        });
    }

</script>
<script type='text/javascript' src='<?php echo v1_get_template_directory_uri(); ?>/js/custom.js?ver=1.0'></script>
<script type='text/javascript' src='<?php echo v1_get_template_directory_uri(); ?>/js/table.js?ver=1.0'></script>
<?php
    wp_footer();
?>
</body>
</html>
