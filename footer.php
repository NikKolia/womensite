 <!-- ________________________Footer________________________-->
 <Footer class="container-fluid whiteBg textColorGrey pb-4 footer">
            <div class="hline-bottom w-100"></div>
            <div class="d-flex justify-content-between footerNav text-uppercase mt-3 pt-4 ">
                <div class="order-md-2 order-lg-1 mb-sm-2">
                    <!-- /* Secondary navigation */ -->
                    <?php
                        wp_nav_menu( array(
                        'menu' => 'bottom_menu',
                        'depth' => 2,
                        'container' => false,
                        'menu_class' => 'nav flex-column',
                        //Process nav menu using our custom nav walker
                        'walker' => new wp_bootstrap_navwalker())
                        );
                        ?>
                </div>
                <div class="d-flex align-items-end order-lg-2 order-md-3 mb-sm-2">
                    <div class="d-flex flex-column text-sm-center">
                        <!-- <a href="" target="_blank"> <img src="<?php bloginfo('template_directory'); ?>/images/Vira_Logo.svg"" alt="ViraLogo"></a> -->
                        <a href="https://www.vira.health/" target="_blank">
                        <img src="<?php bloginfo('template_directory'); ?>/images/vira_footer.png" alt="copyrightLogo" class="img-fluid copyright_logo d-block mx-sm-auto">
                        </a>
                        <p class="mb-0 mt-2 textSmall text-capitalize">© <?php echo date('Y'); ?> Menopause What Works, All Rights Reserved.</p>
                    </div>
                </div>
                <div class="d-flex flex-column justify-content-between order-sm-1 order-lg-3 mb-sm-2 flexDevicerow bottm_row">
                    <div>
                        <img src="<?php bloginfo('template_directory'); ?>/images/bottomLogo.svg" alt="footerLogo" class="img-fluid">
                    </div>
                    <div>
                        <div class="d-flex justify-content-end">
                            <?php
                                $fb_profile_link     = !empty(vira_get_theme_option('fb_profile_link')) ? vira_get_theme_option('fb_profile_link') : '';
                                $twitter_handle_link = !empty(vira_get_theme_option('twitter_handle_link')) ? vira_get_theme_option('twitter_handle_link') : '';
                                $instagram_link      = !empty(vira_get_theme_option('instagram_link')) ? vira_get_theme_option('instagram_link') : '';
                            ?>
                            <!-- <a href="<?php echo $twitter_handle_link; ?>" target="_blank" class="m-1"> <img src="<?php bloginfo('template_directory'); ?>/images/twitter.svg" alt="Twitter"></a> -->
                            <a href="<?php echo $fb_profile_link; ?>" target="_blank" class="m-1"> <img src="<?php bloginfo('template_directory'); ?>/images/facebook.svg" alt="Facebook"></a>
                            <a href="<?php echo $instagram_link; ?>" target="_blank" class="m-1"> <img src="<?php bloginfo('template_directory'); ?>/images/instagram.svg" alt="Instagram"></a>
                        </div>
                    </div>
                </div>
            </div>

    </Footer>

    <!-- Wordpress Footer -->
    <?php wp_footer(); ?>

    <!-- Loader -->
    <!-- <div class="d-flex align-items-center justify-content-center w-100">
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div> -->
    <!-- Loader End -->

</body>
</html>