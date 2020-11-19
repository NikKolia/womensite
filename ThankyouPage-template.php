<?php /* Template Name: Thank You Page */ ?>
<?php 
    $url                 = urlencode( site_url() );
    
    $twitter_description = !empty(vira_get_theme_option('twitter_description')) ? vira_get_theme_option('twitter_description') : 'Menopause What Works';
    
    $email_subject       = !empty(vira_get_theme_option('email_subject')) ? vira_get_theme_option('email_subject') : 'Menopause';
    $email_description   = !empty(vira_get_theme_option('email_description')) ? stripslashes( vira_get_theme_option('email_description') ) : 'Menopause';
    
    $whatsapp            = !empty(vira_get_theme_option('whats_app')) ? urlencode( vira_get_theme_option('whats_app') ) : 'Menopause What Works';
    
    $instagram_link      = !empty(vira_get_theme_option('instagram_link')) ? vira_get_theme_option('instagram_link') : '';
?>

<?php get_header('thankyou'); ?>  
 <section class='w-100'>
    <div class="thankyouPage mt-95 container-fluid pt-5 ">
        <div class="contentContainer w-75 margin-auto text-center">
            <p class="orangeBg p-4 b">Thank you for taking the time to share your experience. If you left your email address, every approved review will automatically be entered in a draw for £250 in John Lewis vouchers. The draw will take place December 21, 2020.<p>
            <p class="orangeBg mt-4 p-4">Your review will help guide other women to make informed decisions about their menopausal health. This effort only works if lots of women participate. As soon as we have enough reviews we will start to share back what women are saying.
            <br/><br/><span>You can help us get there.</span></p>
            <div class="d-flex justify-content-center align-items-center socialMedia">
                    <div class="m-2">
                        <a target="_blank" class="d-lg-inline d-none" href="https://twitter.com/intent/tweet?text=<?php echo $twitter_description; ?>&url=<?php echo $url; ?>">
                            <img src="<?php bloginfo('template_directory'); ?>/images/twitter-b.svg" alt=""/>
                        </a>
                        <a target="_blank" class="d-lg-none" href="twitter://intent/tweet?text=<?php echo $twitter_description; ?>&url=<?php echo $url; ?>">
                            <img src="<?php bloginfo('template_directory'); ?>/images/twitter-b.svg" alt=""/>
                        </a>
                    </div>
                    <?php if( isMobile() ){ ?>
                        <div class="m-2">
                            <a   href="<?php echo $instagram_link; ?>" target="_blank" >
                                <img src="<?php bloginfo('template_directory'); ?>/images/instagram-b.svg" alt=""/>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="m-2">
                    <a target="_blank" class="d-lg-inline d-none" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>">
                        <img src="<?php bloginfo('template_directory'); ?>/images/facebook-b.svg" alt=""/>
                    </a>
                        <a target="_blank" class="d-lg-none" href="facebook://sharer/sharer.php?u=<?php echo $url; ?>">
                            <img src="<?php bloginfo('template_directory'); ?>/images/facebook-b.svg" alt=""/>
                        </a>
                    </div>
                    <?php if( isMobile() ){ ?>
                        <div class="m-2">
                            <a target="_blank" href="whatsapp://send?text=<?php echo $url.' | '.$whatsapp; ?>" data-action="share/whatsapp/share">
                                <img src="<?php bloginfo('template_directory'); ?>/images/whatsapp-b.svg" alt=""/>
                            </a>
                        </div>
                    <?php } ?>
                    
                    <div class="m-2">
                        <a target="_blank" href="mailto:?subject=<?php echo $email_subject ?>&body=<?php echo $email_description; ?> ?>">
                            <img src="<?php bloginfo('template_directory'); ?>/images/mailbox.svg" width="60" alt="" style="vertical-align: top;" />
                        </a>
                    </div>
                    
            </div>
        </div>
    </div>
 </section>    
 
</section>
<?php get_footer(); ?>