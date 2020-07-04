<?php
/*
 * Template Name: You are included
 * Template Post Type: post
 */
get_header();
educator_edge_get_title();
get_template_part('slider');

global $post;

if (have_posts()) : while (have_posts()) : the_post();

    $instructor = null;
    $instructor_id = get_post_meta( get_the_ID(), 'instructor', true);
    if (!empty($instructor_id)) {
	    $instructor = wp_get_single_post($instructor_id);
    }

    $video_url = trim(get_post_meta( get_the_ID(), 'video', true));
    $audio_url = trim(get_post_meta( get_the_ID(), 'audio_url', true));

    //Get blog single type and load proper helper
    educator_edge_include_blog_helper_functions('singles', 'standard');

    //Action added for applying module specific filters that couldn't be applied on init
    do_action('educator_edge_blog_single_loaded');

    //Get classes for holder and holder inner
    $edgt_holder_params = educator_edge_get_holder_params_blog();
    ?>
    <style>
     #yi-tabs.ui-widget.ui-widget-content {
       border: none;
    }
    #yi-tabs .ui-widget-header {
      border:none;
      background:none;
      border-bottom: 1px solid #ddd;
    }
    .yi-fa {
       padding: 0.5rem;
    }
    #yi-tabs .ui-tabs-active.ui-state-active {
      background-color:transparent;
      border-color: #ddd;
    }
    #yi-tabs .ui-state-active a{
      color: #444;
    }
    .yi-tab-content {
        min-height: 500px;
        overflow: auto;
    }
 
    </style>
    <div class="<?php echo esc_attr($edgt_holder_params['holder']); ?>">
        <?php do_action('educator_edge_after_container_open'); ?>
        <div class="<?php echo esc_attr($edgt_holder_params['inner']); ?>">
        <div class="edgt-grid-row">
            <div <?php echo educator_edge_get_content_sidebar_class(); ?>>
                <h3 itemprop="name" class="yi-title entry-title edgt-post-title"><?php echo $post->post_title;?> 
                <?php if (!empty($instructor)) {?>
                    with <?php echo $instructor->post_title;?>
                <?php }?>
                </h3>
                <div><?php the_excerpt();?></div>
                <div id="yi-tabs">
                    <ul>
                        <?php if (!empty($video_url)) { ?>
                                    <li><a href="#tabs-video"><i class="yi-fa fa fa-video-camera"></i>Video</a></li>
                        <?php }?>
                        <?php if (!empty($audio_url)) { ?>
                                    <li><a href="#tabs-audio"><i class="yi-fa fa fa-headphones"></i>Audio</a></li>
                        <?php }?>
                        <!-- <li><a href="#tabs-download"><i class="yi-fa fa fa-download"></i>Download</a></li>-->
                        <li><a href="#tabs-trancript"><i class="yi-fa fa fa-book"></i>Transcript</a></li>
                    </ul>
			        <?php if (!empty($video_url)) { ?>
                        <div id="tabs-video" class="yi-tab-content">
                            <p>
                                <video controls="controls" width="80%" height="auto" autoplay>
                                    <source src="<?php echo $video_url;?>" type="video/mp4" />
                                    Your browser does not support the video tag.
                                </video>
                            </p>
                        </div>
                    <?php }?>
                    <?php if (!empty($audio_url)) { ?>
                                <div id="tabs-audio" class="yi-tab-content">
                                    <p>
                                        <audio controls="controls">
                                            <source src="<?php echo $audio_url?>" type="audio/mpeg" width="100%" />
                                            Your browser does not support online audio player.
                                        </audio>
                                    </p>
                                </div>
                    <?php }?>
                        <!--
                        <div id="tabs-download"  class="yi-tab-content">
                            <p>Link1</p>
                            <p>Link2</p>
                        </div>
                        -->
                    <div id="tabs-trancript"  class="yi-tab-content">
                        <?php//  educator_edge_get_blog_single('standard'); ?>
                        <div class="controls" style="height:25px" title="Print transcript">
                            <i class="yi-fa fa fa-print" style="float:right;"></i>
                        </div>
                        <div class="edgt-post-text-maini printDiv">
                            <?php the_content();?>
                        </div>
                    </div>               
                </div>
                <?php if (!empty($instructor)) {?>
                    <h3>About <?php echo $instructor->post_title;?></h3>
                    <div><?php echo wpautop($instructor->post_content);?></div>
                    <a href="#">Read more</a>
                <?php }?>
                <?php do_action('educator_edge_page_after_content');?>
            </div>
            <?php if($edgt_sidebar_layout !== 'no-sidebar') { ?>
                <div <?php echo educator_edge_get_sidebar_holder_class(); ?>>
                        <?php get_sidebar(); ?>
                </div>
            <?php } ?>   
        </div>
        <?php do_action('educator_edge_before_container_close'); ?>
    </div>
<?php endwhile; endif;

get_footer(); ?>


<?php
function get_sidebar_for_yi_resources() {
}
?>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
jQuery(document).ready(function() {
    jQuery( function() {
        jQuery( "#yi-tabs" ).tabs();
    });
    jQuery(".fa-print").on('click', function() {printDiv();});
})

function printDiv() 
{
  var divToPrint=jQuery('.printDiv');
  var newWin=window.open('_blank','Print-Window');
  var title=jQuery(".yi-title.entry-title").text();
   newWin.document.open();
  newWin.document.write('<html><body onload="window.print()"><h2>'+title+'</h2>'+divToPrint.html()+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
}
</script>
