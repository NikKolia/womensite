<?php


/* Theme setup - Adding Navigation Bootdtrap */
add_action('after_setup_theme', 'wpt_setup');
if (!function_exists('wpt_setup')):
    function wpt_setup()
    {
        register_nav_menu('primary', __('Primary navigation', 'wptuts'));
        register_nav_menu('secondary', __('Secondary navigation', 'wptuts2'));
    } endif;


/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}

add_action('after_setup_theme', 'register_navwalker');


//  Loading Stylesheets
function load_stylesheets()
{
    // Loading Bootstrap
    wp_register_style('bootstrap4', get_template_directory_uri() . '/css/bootstrap.min.css', array(), false, 'all');
    wp_enqueue_style('bootstrap4');

    // Loading Variables
    wp_register_style('variablesCss', get_template_directory_uri() . '/css/variables.css', array(), false, 'all');
    wp_enqueue_style('variablesCss');

    // Loading Variables
    wp_register_style('responsiveCss', get_template_directory_uri() . '/css/responsive.css', array(), false, 'all');
    wp_enqueue_style('responsiveCss');

    // Loading Multislect CSS
    wp_register_style('multi-select-css', get_template_directory_uri() . '/css/bootstrap-multiselect.css', array(), false, 'all');
    wp_enqueue_style('multi-select-css');

    // Loading Custom Style
    wp_register_style('style', get_template_directory_uri() . '/style.css', array(), false, 'all');
    wp_enqueue_style('style');

    wp_register_style('jquery-ui', get_template_directory_uri() . '/css/jquery-ui.min.css', array(), false, 'all');
    wp_enqueue_style('jquery-ui');

    wp_register_style('redesign', get_template_directory_uri() . '/css/redesign.css', array(), false, 'all');
    wp_enqueue_style('redesign');

}


add_action('wp_enqueue_scripts', 'load_stylesheets');


// Loading Jquery

function load_jquery()
{

    // wp_deregister_script('jquery');

    // Loading jquery
    // wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-3.2.1.slim.min.js' , '', 1, true);
    // wp_enqueue_script('jquery');

}

add_action('wp_enqueue_scripts', 'load_jquery');


//  Loading Javascripts

function load_javascript()
{

    // Loading Popper
    wp_register_script('popperFile', get_template_directory_uri() . '/js/popper.min.js', '', 1, true);
    wp_enqueue_script('popperFile');

    // Loading bootstrapjs
    wp_register_script('bootstrapjsFile', get_template_directory_uri() . '/js/bootstrap.min.js', '', 1, true);
    wp_enqueue_script('bootstrapjsFile');

    // Loading customjs
    wp_register_script('customJS', get_template_directory_uri() . '/js/scripts.js', '', 1, true);
    wp_enqueue_script('customJS');

    wp_register_script('multi-select-js', get_template_directory_uri() . '/js/bootstrap-multiselect.js', array('jquery'), 1, true);
    wp_enqueue_script('multi-select-js');

    wp_register_script('viraJS', get_template_directory_uri() . '/js/vira.js', array('jquery', 'multi-select-js', 'jquery-ui-autocomplete'), 1, true);
    wp_enqueue_script('viraJS');

    if (317 == get_the_ID()) {
        wp_register_script('jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), 1, true);
        wp_enqueue_script('jquery-validate');
    }
    wp_enqueue_script('jquery-ui-autocomplete');

}

add_action('wp_enqueue_scripts', 'load_javascript');


function vira_post_thumbnail_sizes_attr($attr)
{

    if (is_admin()) {
        return $attr;
    }

    if (!is_singular()) {
        $attr['sizes'] = '(max-width: 34.9rem) calc(100vw - 2rem), (max-width: 53rem) calc(8 * (100vw / 12)), (min-width: 53rem) calc(6 * (100vw / 12)), 100vw';
    }

    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'vira_post_thumbnail_sizes_attr', 10, 1);


if (!function_exists('vira_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function vira_post_thumbnail()
    {
        if (!vira_can_show_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <figure class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </figure><!-- .post-thumbnail -->

        <?php
        else :
            ?>

            <figure class="post-thumbnail">
                <a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail('post-thumbnail'); ?>
                </a>
            </figure>

        <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('vira_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function vira_entry_footer()
    {

        // Hide author, post date, category and tag text for pages.
        if ('post' === get_post_type()) {

            // Posted by.
            vira_posted_by();

            // Posted on.
            vira_posted_on();

            /* translators: Used between list items, there is a space after the comma. */
            $categories_list = get_the_category_list(__(', ', 'twentynineteen'));
            if ($categories_list) {
                printf(
                /* translators: 1: SVG icon. 2: Posted in label, only visible to screen readers. 3: List of categories. */
                    '<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
                    vira_get_icon_svg('archive', 16),
                    __('Posted in', 'twentynineteen'),
                    $categories_list
                ); // WPCS: XSS OK.
            }

            /* translators: Used between list items, there is a space after the comma. */
            $tags_list = get_the_tag_list('', __(', ', 'twentynineteen'));
            if ($tags_list) {
                printf(
                /* translators: 1: SVG icon. 2: Posted in label, only visible to screen readers. 3: List of tags. */
                    '<span class="tags-links">%1$s<span class="screen-reader-text">%2$s </span>%3$s</span>',
                    vira_get_icon_svg('tag', 16),
                    __('Tags:', 'twentynineteen'),
                    $tags_list
                ); // WPCS: XSS OK.
            }
        }

        // Comment count.
        if (!is_singular()) {
            vira_comment_count();
        }

        // Edit post link.
        edit_post_link(
            sprintf(
                wp_kses(
                /* translators: %s: Post title. Only visible to screen readers. */
                    __('Edit <span class="screen-reader-text">%s</span>', 'twentynineteen'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<span class="edit-link">' . vira_get_icon_svg('edit', 16),
            '</span>'
        );
    }
endif;

if (!function_exists('vira_posted_by')) :
    /**
     * Prints HTML with meta information about theme author.
     */
    function vira_posted_by()
    {
        printf(
        /* translators: 1: SVG icon. 2: Post author, only visible to screen readers. 3: Author link. */
            '<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
            vira_get_icon_svg('person', 16),
            __('Posted by', 'twentynineteen'),
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_html(get_the_author())
        );
    }
endif;

if (!function_exists('vira_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function vira_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        printf(
            '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
            vira_get_icon_svg('watch', 16),
            esc_url(get_permalink()),
            $time_string
        );
    }
endif;

if (!function_exists('vira_discussion_avatars_list')) :
    /**
     * Displays a list of avatars involved in a discussion for a given post.
     */
    function vira_discussion_avatars_list($comment_authors)
    {
        if (empty($comment_authors)) {
            return;
        }
        echo '<ol class="discussion-avatar-list">', "\n";
        foreach ($comment_authors as $id_or_email) {
            printf(
                "<li>%s</li>\n",
                vira_get_user_avatar_markup($id_or_email)
            );
        }
        echo '</ol><!-- .discussion-avatar-list -->', "\n";
    }
endif;

if (!function_exists('vira_comment_count')) :
    /**
     * Prints HTML with the comment count for the current post.
     */
    function vira_comment_count()
    {
        if (!post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            echo vira_get_icon_svg('comment', 16);

            /* translators: %s: Post title. Only visible to screen readers. */
            comments_popup_link(sprintf(__('Leave a comment<span class="screen-reader-text"> on %s</span>', 'twentynineteen'), get_the_title()));

            echo '</span>';
        }
    }
endif;

function vira_can_show_post_thumbnail()
{
    return apply_filters('vira_can_show_post_thumbnail', !post_password_required() && !is_attachment() && has_post_thumbnail());
}

function vira_get_icon_svg()
{
    return '';
}

function vira_get_discussion_data()
{
    static $discussion, $post_id;

    $current_post_id = get_the_ID();
    if ($current_post_id === $post_id) {
        return $discussion; /* If we have discussion information for post ID, return cached object */
    } else {
        $post_id = $current_post_id;
    }

    $comments = get_comments(
        array(
            'post_id' => $current_post_id,
            'orderby' => 'comment_date_gmt',
            'order' => get_option('comment_order', 'asc'), /* Respect comment order from Settings » Discussion. */
            'status' => 'approve',
            'number' => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
        )
    );

    $authors = array();
    foreach ($comments as $comment) {
        $authors[] = ((int)$comment->user_id > 0) ? (int)$comment->user_id : $comment->comment_author_email;
    }

    $authors = array_unique($authors);
    $discussion = (object)array(
        'authors' => array_slice($authors, 0, 6),           /* Six unique authors commenting on the post. */
        'responses' => get_comments_number($current_post_id), /* Number of responses. */
    );

    return $discussion;
}


function wpbeginner_remove_version()
{
    return '';
}

add_filter('the_generator', 'wpbeginner_remove_version');


function no_wordpress_errors($error)
{
    return 'Something is wrong!';
}

function registeraction()
{

    if ($_GET['action'] != 'register') {
        add_filter('login_errors', 'no_wordpress_errors');
    }
}

function myplugin_check_fields($errors, $sanitized_user_login, $user_email)
{
    //echo "sanitized_user_login: $sanitized_user_login";
    if ($sanitized_user_login == "root" || $sanitized_user_login == "admin") {
        $errors->add('bad_username', '<strong>ERROR</strong>:Username should be strong.');
    }
    return $errors;
}

add_filter('registration_errors', 'myplugin_check_fields', 10, 3);


if (function_exists('slt_fsp_init')) {
    //plugin is activated
    add_filter('slt_fsp_caps_check', '__return_empty_array');
}

include('functions/cpt_functions.php');
include('functions/custom_functions.php');
include('functions/review_functions.php');
include('functions/customizer.php');



