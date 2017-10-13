<?php
 
 /**
  * Register script
  */
  
function clndr_register_scripts_and_styles(){
	wp_enqueue_script( 
	    'clndr-underscore', 
		plugins_url( '../js/underscore.min.js' , __FILE__ ),
		array( 'jquery' ));
	wp_enqueue_script( 
        'clndr-moment-with-locales',
	    plugins_url( '../js/moment-with-locales.min.js' , __FILE__ ),
		array( 'jquery' ));
	wp_enqueue_script( 
	    'clndr',
	    plugins_url( '../js/clndr.min.js' , __FILE__ ),
		array( 'jquery', 'clndr-moment-with-locales', 'clndr-underscore' ));
	wp_enqueue_script( 
	    'clndr-cal1-config',
	    plugins_url( '../config.js' , __FILE__ ),
		array( 'jquery', 'clndr-moment-with-locales', 'clndr-underscore', 'clndr' ));
	

	wp_enqueue_style( 'clndr_css', plugins_url( '../css/clndr.css' , __FILE__ ));
}

/**
 * Load events on calendar
 */
	
function clndr_load_events_from_db(){
	$args = array(
		'post_type' => array( 'easy_event' ),
		'posts_per_page' => - 1,
	);
	$the_query = new WP_Query( $args );
	
	$input_date_format = 'd/m/Y';
	$output_date_format = 'Y-m-d';
	$eventArray = array();
	
	echo '<script>';
	echo 'var eventArray = ';

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$event = array();
			/* Retrieve event information */
			$event_title = esc_attr(get_the_title(get_the_ID()));
			$date_event_start = get_post_meta( get_the_ID(), 'easy_event_date_start', true );
			$date_event_finish = get_post_meta( get_the_ID(), 'easy_event_date_finish', true );
			$link = esc_url(get_permalink(get_the_ID()));
			
			if ( $date_event_start == '' || $date_event_start == false ) {
				continue;
			}
			
			/* Convert string to Datetime object */
			$date_event_start = DateTime::createFromFormat(
				$input_date_format,
				$date_event_start
			);
			$date_event_end = DateTime::createFromFormat(
				$input_date_format,
				$date_event_finish
			);
			
			/*Create javascript array element for calendar*/
			$event["title"] = $event_title;
			$event["link"] = $link;
			if( $date_event_start == $date_event_end ) {
				$event["date"] = $date_event_start->format($output_date_format);
			}else{
				$event["startDate"] = $date_event_start->format($output_date_format);
				$event["endDate"] = $date_event_end->format($output_date_format);
			}
			
			array_push($eventArray,$event);
		}
	}
	
	/*Convert event array to JSON */
	echo json_encode($eventArray).';';
	
	echo '</script>';
	
	clndr_register_scripts_and_styles();
}

function clndr_print() {
	?>
	<div class="container">
        <div class="cal1"></div>
		<script id="int-template" type="text/template">
		<div class="clndr-controls">
			<div class="clndr-control-button">
				<span class="clndr-previous-button">&lsaquo;</span>
			</div>
			<div class="month"><%= month %> <%= year %></div>
			<div class="clndr-control-button rightalign">
				<span class="clndr-next-button">&rsaquo;</span>
			</div>
		</div>
		<table class="clndr-table" border="0" cellspacing="0" cellpadding="0">
			<thead>
				<tr class="header-days">
					<% for(var i = 0; i < daysOfTheWeek.length; i++) { %>
					<td class="header-day"><%= daysOfTheWeek[i] %></td><% } %>
				</tr>
			</thead>
			<tbody><% for(var i = 0; i < numberOfRows; i++){ %>
				<tr><% for(var j = 0; j < 7; j++){ %><% var d = j + i * 7; %>
					<td class="<%= days[d].classes %>">
						<div class="day-contents"><%= days[d].day %></div>
					</td><% } %>
				</tr><% } %>
			</tbody>
		</table>
		<div class="box" ></div>
		</script>
    </div>
	<?php
}