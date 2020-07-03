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
    //Get blog single type and load proper helper
    educator_edge_include_blog_helper_functions('singles', 'standard');

    //Action added for applying module specific filters that couldn't be applied on init
    do_action('educator_edge_blog_single_loaded');

    //Get classes for holder and holder inner
    $edgt_holder_params = educator_edge_get_holder_params_blog();
//var_dump($post);
//var_dump($edgt_holder_params);
//$post->post_content;
// $post->ID
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
 
    </style>
    <div class="<?php echo esc_attr($edgt_holder_params['holder']); ?>">
        <?php do_action('educator_edge_after_container_open'); ?>
        <div class="edgt-container-inner clearfix"> 
    	  <div <?php echo educator_edge_get_content_sidebar_class(); ?>>
             <h2 itemprop="name" class="yi-title entry-title edgt-post-title"><?php echo $post->post_title;?></h2>   
             <div class="<?php echo esc_attr($edgt_holder_params['inner']); ?>">
               <div id="yi-tabs">
                <ul>
                    <li><a href="#tabs-video"><i class="yi-fa fa fa-video-camera"></i>Video</a></li>
                    <li><a href="#tabs-audio"><i class="yi-fa fa fa-headphones"></i>Audio</a></li>
                    <!-- <li><a href="#tabs-download"><i class="yi-fa fa fa-download"></i>Download</a></li>-->
                    <li><a href="#tabs-trancript"><i class="yi-fa fa fa-book"></i>Transcript</a></li>
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
		<!--
                <div id="tabs-download">
                    <p>Link1</p>
                    <p>Link2</p>
                </div>
		-->
                <div id="tabs-trancript">
                    <?php//  educator_edge_get_blog_single('standard'); ?>
		    <div class="controls" style="height:25px" title="Print transcript">
		      <i class="yi-fa fa fa-print" style="float:right;"></i>
		    </div>
		    <div class="edgt-post-text-maini printDiv">
		      <?php
                          the_content();
                          do_action('educator_edge_page_after_content');
                       ?>
		    </div>
                </div>                
              </div>
            </div>
 
<?php if($edgt_sidebar_layout !== 'no-sidebar') { ?>
                                        <div <?php echo educator_edge_get_sidebar_holder_class(); ?>>
                                                <?php get_sidebar(); ?>
                                        </div>
                                <?php } ?>         </div>
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
