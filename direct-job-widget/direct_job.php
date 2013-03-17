<?php
/**
 * Plugin Name: Directjob widget
 
 * Plugin URI: http://directjob.bzh.be
 
 * Description: Last job offer from Directjob
 
 * Author: Hilflo
 
 * Version: 1.0
 
 * Author URI: http://directjob.bzh.be
 
 * License: GPLv2 or later 
 */

class directjob_widget extends WP_Widget {

	// Constructor //

		function directjob_widget() {
			$widget_ops = array( 'classname' => 'directjob_widget', 'description' => 'Job offer from diretcjob' ); // Widget Settings
			$control_ops = array( 'id_base' => 'directjob_widget' ); // Widget Control Settings
			$this->WP_Widget( 'directjob_widget', 'Job offer', $widget_ops, $control_ops ); // Create the widget
		}

	// Extract Args //

		function widget($args, $instance) {
			extract( $args );
			$title 		= apply_filters('widget_title', $instance['title']); // the widget title
			$r_c_number	= $instance['r_c_number']; // choix de la region
			$state 	= $instance['state']; // choix de la region
			$city = $instance['city']; // choix du departement
			$keyword = $instance['keyword'];
	// Before widget //

			echo $before_widget;
		

	// Title of widget //

			if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

	// Widget output //
			$rss = 'http://directjob.bzh.be/directjob_widget.php?limit='.$r_c_number.'&state='.$state.'&city='.$city.'&key='.$keyword;
			echo $rss;
			if(!$xml=simplexml_load_file($rss)){
			trigger_error('Error reading XML file',E_USER_ERROR);
			}
		?>

<ul>
    <?php 
    foreach ( $xml as $item ) : 
	?>
    <li>	
        <a href='<?php echo esc_url( $item->link ); ?>'
        title='<?php echo esc_html( $item->desc ); ?>'>
        <?php echo esc_html( $item->title ); ?></a><br />
		<?php echo $item->city; ?> | <?php echo $item->date; ?><br />
    </li>
    <?php endforeach; ?>
	<li style="font-size:10px;text-align:right;float:right">Offres fournies par <a href="http://directjob.bzh.be">DirectJob</a></li>
</ul>
			
			<?php
			

	// After widget //

			echo $after_widget;
		}

	// Update Settings //

		function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['r_c_number'] = strip_tags($new_instance['r_c_number']);
			$instance['state'] = strip_tags($new_instance['state']);
			$instance['city'] = strip_tags($new_instance['city']);
			$instance['keyword'] = strip_tags($new_instance['keyword']);
			return $instance;
		}

	// Widget Control Panel //
		

		function form($instance) {
		$defaults = array( 'title' => 'Last Job offer', 'r_c_number' => 5, 'state' => '', 'city' => '', 'keyword' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('title'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('r_c_number'); ?>"><?php _e('number'); ?>:</label>
			<select id="<?php echo $this->get_field_id('r_c_number'); ?>" name="<?php echo $this->get_field_name('r_c_number'); ?>'">
			<option value="<?php echo $instance['r_c_number']; ?>"><?php echo $instance['r_c_number']; ?></option>
			<option value="5">5</option>
			<option value="10">10</option>
			<option value="15">15</option>
			<option value="20">20</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('state'); ?>"><?php _e('state'); ?></label>
			<select name="<?php echo $this->get_field_name('state'); ?>">
				<option value="<?php echo $instance['state']; ?>"><?php echo $instance['state']; ?></option>
				<option value="au">Australia</option>
				<option value="au">Australia</option>
				<option value="at">Austria</option>
				<option value="be">Belgium</option>
				<option value="br">Brazil</option>
				<option value="ca">Canada</option>
				<option value="fr">France</option>
				<option value="de">Germany</option>
				<option value="in">India</option>
				<option value="ie">Ireland</option>
				<option value="it">Italy</option>
				<option value="mx">Mexico</option>
				<option value="nl">Netherlands</option>
				<option value="es">Spain</option>
				<option value="ch">Switzerland</option>
				<option value="gb">United Kingdom</option>
				<option value="us">United States</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('city'); ?>"><?php _e('Ville'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('city'); ?>" name="<?php echo $this->get_field_name('city'); ?>'" type="text" value="<?php echo $instance['city']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('keyword'); ?>"><?php _e('Mots cl&eacute;s'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('keyword'); ?>" name="<?php echo $this->get_field_name('keyword'); ?>'" type="text" value="<?php echo $instance['keyword']; ?>" />
		</p>
        <?php }

}

add_action('widgets_init', create_function('', 'return register_widget("directjob_widget");'));

?>