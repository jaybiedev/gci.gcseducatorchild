<?php
/*
 * Template Name: You are included
 * Template Post Type: post
 */
get_header();
educator_edge_get_title();
get_template_part('slider');

if (have_posts()) : while (have_posts()) : the_post();
    //Get blog single type and load proper helper
    educator_edge_include_blog_helper_functions('singles', 'standard');

    //Action added for applying module specific filters that couldn't be applied on init
    do_action('educator_edge_blog_single_loaded');

    //Get classes for holder and holder inner
    $edgt_holder_params = educator_edge_get_holder_params_blog();
    ?>
    <div class="<?php echo esc_attr($edgt_holder_params['holder']); ?>">
        <?php do_action('educator_edge_after_container_open'); ?>
        
        <div class="<?php echo esc_attr($edgt_holder_params['inner']); ?>">
            <div id="yi-tabs">
                <ul>
                    <li><a href="#tabs-video">Video</a></li>
                    <li><a href="#tabs-audio">Audio</a></li>
                    <li><a href="#tabs-download">Download</a></li>
                    <li><a href="#tabs-trancript">Transcript</a></li>
                </ul>
                <div id="tabs-video">
                    <p>
                        <video controls="controls" width="80%" height="auto">
                            <source src="http://gcitv.net/dl/YI/YI008-320.mp4" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                    </p>
                </div>
                <div id="tabs-audio">
                    <p>
                        <audio controls="controls">
                            <source src="http://gcitv.net/dl/YI/YI008.mp3" type="audio/mpeg" width="100%" />
                            Your browser does not support online audio player.
                        </audio>
                    </p>
                </div>
                <div id="tabs-download">
                    <p>Link1</p>
                    <p>Link2</p>
                </div>
                <div id="tabs-trancript">
                    <?php educator_edge_get_blog_single('standard'); ?>
                </div>                
            </div>
            
        </div>
        
        <?php do_action('educator_edge_before_container_close'); ?>
    </div>
<?php endwhile; endif;

get_footer(); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
jQuery(document).ready(function() {
    jQuery( function() {
        jQuery( "#yi-tabs" ).tabs();
    });
})
</script>