<?php
/**
 * Widget API: WP_Widget_Instructors_Posts_List class
 *
 * @package GCS Educator Child
 * @subpackage Widgets
 * @since 0.0.1
 */

/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Instructors_Posts_List extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_instructors_posts_list',
			'description'                 => __( 'Instructors Posts List.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'instructors-posts-list', __( 'Instructors Posts List' ), $widget_ops );
		$this->alt_option_name = 'widget_instructors_post_list';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Instructors Posts List' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$includeCats = ( ! empty( $instance['includeCats'] ) ) ? $instance['includeCats'] : [];

	        // print_r($includeCats);
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		
		$r = new WP_Query(
			/**
			 * Filters the arguments for the Recent Posts widget.
			 *
			 * @since 3.4.0
			 * @since 4.9.0 Added the `$instance` parameter.
			 *
			 * @see WP_Query::get_posts()
			 *
			 * @param array $args     An array of arguments used to retrieve the recent posts.
			 * @param array $instance Array of settings for the current widget.
			 * @todo: add category filter
			 */
			apply_filters(
				'widget_posts_args',
				array(
					'post_type'			  => array('instructor'),
					'posts_per_page'      => $number,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'orderby'             => 'menu_order title',
					'order'               => 'ASC',
					'tax_query' => array(
						'relation' => 'AND',
							array(
								'taxonomy' => 'instructor-category',
								'field'    => 'term_id',
								'terms'    => $includeCats,
							'include_children' =>false,
							),
						),				
				),
				$instance
			)
		);

		if ( ! $r->have_posts() ) {
			return;
		}
		?>
		<?php echo $args['before_widget']; ?>
		<?php
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		<div class="widget widget_nav_menu">
		<div class="menu-resources-sidebar-container">
		<ul id="<?php echo $this->id;?>" class="menu">
			<?php foreach ( $r->posts as $instructor_post ) : ?>
				<?php
				// $post_title   = get_the_title( $instructor_post->ID );
				$title        = ( ! empty( $instructor_post->post_title ) ) ? $instructor_post->post_title : __( '(no title)' );
				$aria_current = '';

				if ( get_queried_object_id() === $instructor_post->ID ) {
					$aria_current = ' aria-current="page"';
				}
				?>
				<li id="menu-item-<?php echo $instructor_post->ID;?>" class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor current-menu-ancestor current-menu-parent current-page-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-<?php echo $instructor_post->ID;?>">
					<a href="<?php the_permalink( $instructor_post->ID );?>" <?php echo $aria_current; ?>><?php echo $title; ?></a>
					<?php if (false &&  $show_date ) : ?>
						<span class="post-date"><?php echo get_the_date( '', $instructor_post->ID ); ?></span>
					<?php endif; ?>
					<?php
						// get posts by instructor
						$instructorArticles = get_posts(array(
							'numberposts'	=> -1,
							'post_type'		=> 'post',
							'meta_key'		=> 'instructor',
							'meta_value'	=> $instructor_post->ID
						));
					?>
						<ul class="sub-menu">
							<?php foreach ($instructorArticles as $article) { 
								if ( get_queried_object_id() === $article->ID ) {
									$aria_current = ' aria-current="page"';
								}								
							?>
								<li  id="menu-item-<?php echo $article->ID;?>" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-4141 current_page_item menu-item-<?php echo $article->ID;?>">
								<a href="<?php the_permalink( $article->ID );?>" <?php echo $aria_current; ?>><?php echo $article->post_title;?></a>
								</li>
							<?php }?>
						</ul>
				</li>
			<?php endforeach; ?>
		</ul>
		</div>
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['includeCats'] = $new_instance['includeCats'];
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$includeCats    = isset( $instance['includeCats'] ) ? absint( $instance['includeCats'] ) : [];
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>"><?php _e( 'Sort by:' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'sortby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>" class="widefat">
					<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php _e( 'Name' ); ?></option>
					<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php _e( 'Order' ); ?></option>
					<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php _e( 'Page ID' ); ?></option>
			</select>
		</p>
		<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'includeCats' ) ); ?>"><?php _e( 'Include categories:' ); ?></label><br />
				<?php $args = array(
					'post_type' => array('instructor'),
					'taxonomy' => 'instructor-category',
					'orderby' => 'name',
               		'order'   => 'ASC'
				);

				$cats = get_categories($args);
				// print_r($cats);
				foreach( $cats as $key => $cat ) { 
					$checked = "";
					if(in_array($cat->term_id, $instance['includeCats'])){
						$checked = "checked='checked'";
					}
					?>
					<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('includeCats'); ?>" name="<?php echo $this->get_field_name( 'includeCats[]' ); ?>" value="<?php echo $cat->term_id;?>"  <?php echo $checked; ?>/>
					<label for="<?php echo $this->get_field_id('includeCats'); ?>"><?php echo $cat->name; ?></label><br />
				<?php } ?>
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<p style="display:none;"><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
		<?php
	}
}
