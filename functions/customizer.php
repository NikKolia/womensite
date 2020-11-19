<?php
/**
 * Create A Simple Theme Options Panel
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Start Class
if (!class_exists('VIRA_Theme_Options')) {

    class VIRA_Theme_Options
    {

        /**
         * Start things up
         *
         * @since 1.0.0
         */
        public function __construct()
        {

            // We only need to register the admin panel on the back-end
            if (is_admin()) {
                add_action('admin_menu', array('VIRA_Theme_Options', 'add_admin_menu'));
                add_action('admin_init', array('VIRA_Theme_Options', 'register_settings'));
            }

        }

        /**
         * Returns all theme options
         *
         * @since 1.0.0
         */
        public static function get_theme_options()
        {
            return get_option('theme_options');
        }

        /**
         * Returns single theme option
         *
         * @since 1.0.0
         */
        public static function get_theme_option($id)
        {
            $options = self::get_theme_options();
            if (isset($options[$id])) {
                return $options[$id];
            }
        }

        /**
         * Add sub menu page
         *
         * @since 1.0.0
         */
        public static function add_admin_menu()
        {
            add_menu_page(
                esc_html__('Theme Settings', 'vira'),
                esc_html__('Theme Settings', 'vira'),
                'manage_options',
                'theme-settings',
                array('VIRA_Theme_Options', 'create_admin_page')
            );
        }

        /**
         * Register a setting and its sanitization callback.
         *
         * We are only registering 1 setting so we can store all options in a single option as
         * an array. You could, however, register a new setting for each option
         *
         * @since 1.0.0
         */
        public static function register_settings()
        {
            register_setting('theme_options', 'theme_options', array('VIRA_Theme_Options', 'sanitize'));
        }

        /**
         * Sanitization callback
         *
         * @since 1.0.0
         */
        public static function sanitize($options)
        {

            // If we have options lets sanitize them
            if ($options) {

                // Checkbox
                if (!empty($options['checkbox_example'])) {
                    $options['checkbox_example'] = 'on';
                } else {
                    unset($options['checkbox_example']); // Remove from options if not checked
                }

                // Input
                if (!empty($options['input_example'])) {
                    $options['input_example'] = sanitize_text_field($options['input_example']);
                } else {
                    unset($options['input_example']); // Remove from options if empty
                }

                // Select
                if (!empty($options['select_example'])) {
                    $options['select_example'] = sanitize_text_field($options['select_example']);
                }

            }

            // Return sanitized options
            return $options;

        }

        /**
         * Settings page output
         *
         * @since 1.0.0
         */
        public static function create_admin_page()
        {
            $active_tab = 'home-options';
            if (isset($_GET['tab'])) {
                $active_tab = $_GET['tab'];
            }
            ?>

            <div class="wrap">

                <h1><?php esc_html_e('Theme Options', 'vira'); ?></h1>
                <h2 class="nav-tab-wrapper">
                    <a href="?page=theme-settings&tab=home-options"
                       class="nav-tab <?php if ($active_tab == 'home-options') {
                           echo 'nav-tab-active';
                       } ?> "><?php _e('Home Page Options', 'vira'); ?></a>
                    <a href="?page=theme-settings&tab=add-review"
                       class="nav-tab <?php if ($active_tab == 'add-review') {
                           echo 'nav-tab-active';
                       } ?>"><?php _e('Add Review Options', 'vira'); ?></a>
                    <a href="?page=theme-settings&tab=add-social"
                       class="nav-tab <?php if ($active_tab == 'add-social') {
                           echo 'nav-tab-active';
                       } ?>"><?php _e('Add Social Options', 'vira'); ?></a>
                </h2>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('theme_options');
                    self::createHomePageTab($active_tab);
                    self::addReviewTab($active_tab);
                    self::addSocialTab($active_tab);
                    // self::createFooterOptionsTab($active_tab);
                    submit_button();
                    ?>
                </form>

            </div><!-- .wrap -->
        <?php }

        public static function createHomePageTab($active_tab)
        {
            ?>
            <h2 style="<?php if ($active_tab == 'home-options') {
                echo 'display: block;';
            } else {
                echo "display: none;";
            } ?>">Section 1 : </h2>
            <table class="form-table wpex-custom-admin-login-table" style="<?php if ($active_tab == 'home-options') {
                echo 'display: block;';
            } else {
                echo "display: none;";
            } ?>">

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Title', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('home_page_title_1'); ?>
                        <input class="regular-text" type="text" name="theme_options[home_page_title_1]"
                               value="<?php echo esc_attr($value); ?>"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Description', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('home_page_description_1'); ?>
                        <textarea rows="5" cols="54"
                                  name="theme_options[home_page_description_1]"><?php echo esc_attr($value); ?></textarea>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Block Details', 'vira'); ?>
                    </th>
                    <td>

                <tr>
                    <td><input class="regular-text" type="text" name="theme_options[home_page_block_title_1]"
                               value="<?php echo $value = self::get_theme_option('home_page_block_title_1'); ?>"/></td>
                    <td><input class="regular-text" type="text" name="theme_options[home_page_block_title_2]"
                               value="<?php echo $value = self::get_theme_option('home_page_block_title_2'); ?>"/></td>
                    <td><input class="regular-text" type="text" name="theme_options[home_page_block_title_3]"
                               value="<?php echo $value = self::get_theme_option('home_page_block_title_3'); ?>"/></td>
                </tr>
                <tr>
                    <td><textarea rows="5" cols="54"
                                  name="theme_options[home_page_block_desc_1]"><?php echo $value = self::get_theme_option('home_page_block_desc_1'); ?></textarea>
                    </td>
                    <td><textarea rows="5" cols="54"
                                  name="theme_options[home_page_block_desc_2]"><?php echo $value = self::get_theme_option('home_page_block_desc_2'); ?></textarea>
                    </td>
                    <td><textarea rows="5" cols="54"
                                  name="theme_options[home_page_block_desc_3]"><?php echo $value = self::get_theme_option('home_page_block_desc_3'); ?></textarea>
                    </td>
                </tr>
                </td>
                </tr>
            </table>
            <hr>
            <h2 style="<?php if ($active_tab == 'home-options') {
                echo 'display: block;';
            } else {
                echo "display: none;";
            } ?>">Section 2 : </h2>
            <table class="form-table wpex-custom-admin-login-table" style="<?php if ($active_tab == 'home-options') {
                echo 'display: block;';
            } else {
                echo "display: none;";
            } ?>">

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Title', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('home_page_title'); ?>
                        <input class="regular-text" type="text" name="theme_options[home_page_title]"
                               value="<?php echo esc_attr($value); ?>"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Description', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('home_page_description'); ?>
                        <textarea rows="5" cols="50"
                                  name="theme_options[home_page_description]"><?php echo esc_attr($value); ?></textarea>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Block Details', 'vira'); ?>
                    </th>
                    <td>

                <tr>
                    <td><input class="regular-text" type="text" name="theme_options[home_page_block_title_4]"
                               value="<?php echo $value = self::get_theme_option('home_page_block_title_4'); ?>"/></td>
                    <td><input class="regular-text" type="text" name="theme_options[home_page_block_title_5]"
                               value="<?php echo $value = self::get_theme_option('home_page_block_title_5'); ?>"/></td>
                    <td><input class="regular-text" type="text" name="theme_options[home_page_block_title_6]"
                               value="<?php echo $value = self::get_theme_option('home_page_block_title_6'); ?>"/></td>
                </tr>
                <tr>
                    <td><textarea rows="5" cols="54"
                                  name="theme_options[home_page_block_desc_4]"><?php echo $value = self::get_theme_option('home_page_block_desc_4'); ?></textarea>
                    </td>
                    <td><textarea rows="5" cols="54"
                                  name="theme_options[home_page_block_desc_5]"><?php echo $value = self::get_theme_option('home_page_block_desc_5'); ?></textarea>
                    </td>
                    <td><textarea rows="5" cols="54"
                                  name="theme_options[home_page_block_desc_6]"><?php echo $value = self::get_theme_option('home_page_block_desc_6'); ?></textarea>
                    </td>
                </tr>
                </td>
                </tr>

            </table>
            <?php
        }

        public static function addReviewTab($active_tab)
        {
            ?>
            <h2 style="<?php if ($active_tab == 'add-review') {
                echo 'display: block;';
            } else {
                echo "display: none;";
            } ?>">Ethnicity: </h2>
            <table class="form-table wpex-custom-admin-login-table add-review-table"
                   style="<?php if ($active_tab == 'add-review') {
                       echo 'display: block;';
                   } else {
                       echo "display: none;";
                   } ?>">
                <?php
                $value = self::get_theme_option('ethnicity');
                if (empty($value)) {
                    $value[0] = '';
                }
                ?>
                <?php foreach ($value as $k => $v) { ?>
                    <tr valign="top" class="treatment-titles" id="first-title">
                        <th scope="row">
                            <?php esc_html_e('Title', 'vira'); ?>
                        </th>
                        <td>
                            <input class="regular-text" type="text" name="theme_options[ethnicity][]"
                                   value="<?php echo esc_attr($v); ?>">
                            <?php if ($k == 0) { ?>
                                <span class="dashicons dashicons-plus-alt add-more-title"
                                      style="color: green; cursor: pointer; vertical-align: middle;"></span>
                            <?php } else { ?>
                                <span class="dashicons dashicons-dismiss remove-title"
                                      style="color: red; cursor: pointer; vertical-align: middle;"></span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php
        }

        public static function addSocialTab($active_tab)
        {
            ?>
            <h2 style="<?php if ($active_tab == 'add-social') {
                echo 'display: block;';
            } else {
                echo "display: none;";
            } ?>">Social Options: </h2>
            <table class="form-table wpex-custom-admin-login-table" style="<?php if ($active_tab == 'add-social') {
                echo 'display: block;';
            } else {
                echo "display: none;";
            } ?>">

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Your FB Profile Link', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('fb_profile_link'); ?>
                        <input class="regular-text" type="text" name="theme_options[fb_profile_link]"
                               value="<?php echo esc_attr($value); ?>"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('FB Title for sharing', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('fb_title'); ?>
                        <input class="regular-text" type="text" name="theme_options[fb_title]"
                               value="<?php echo esc_attr($value); ?>"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('FB Description for sharing', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('fb_description'); ?>
                        <textarea rows="5" cols="54"
                                  name="theme_options[fb_description]"><?php echo esc_attr($value); ?></textarea>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Your Twitter handle Link', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('twitter_handle_link'); ?>
                        <input class="regular-text" type="text" name="theme_options[twitter_handle_link]"
                               value="<?php echo esc_attr($value); ?>"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Twitter Description for sharing', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('twitter_description'); ?>
                        <textarea rows="5" cols="54"
                                  name="theme_options[twitter_description]"><?php echo esc_attr($value); ?></textarea>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Instagram Link', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('instagram_link'); ?>
                        <input class="regular-text" type="text" name="theme_options[instagram_link]"
                               value="<?php echo esc_attr($value); ?>"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Email Subject', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('email_subject'); ?>
                        <input class="regular-text" type="text" name="theme_options[email_subject]"
                               value="<?php echo esc_attr($value); ?>"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Email for sharing', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('email_description'); ?>
                        <textarea rows="5" cols="54"
                                  name="theme_options[email_description]"><?php echo esc_attr($value); ?></textarea>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Whats App', 'vira'); ?>
                    </th>
                    <td>
                        <?php $value = self::get_theme_option('whats_app'); ?>
                        <textarea rows="5" cols="54"
                                  name="theme_options[whats_app]"><?php echo esc_attr($value); ?></textarea>
                    </td>
                </tr>

            </table>
            <hr>
            <?php
        }

    }
}
new VIRA_Theme_Options();

// Helper function to use in your theme to return a theme option value
function vira_get_theme_option($id = '')
{
    return VIRA_Theme_Options::get_theme_option($id);
}
