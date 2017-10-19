<?php
/*
Plugin Name: Advanced Notes Widgets.
Description: Change boring login to custom login .
Author: Shirshak Bajgain
Version: 1.0
Text Domain: shirshak
License: 
All rights reserved.



Redistribution and use in source and binary forms, with or without

modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright

      notice, this list of conditions and the following disclaimer.

    * Redistributions in binary form must reproduce the above copyright

      notice, this list of conditions and the following disclaimer in the

      documentation and/or other materials provided with the distribution.

    * Neither the name of the Studio 42 Ltd. nor the

      names of its contributors may be used to endorse or promote products

      derived from this software without specific prior written permission.



THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND

ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED

WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE

DISCLAIMED. IN NO EVENT SHALL "STUDIO 42" BE LIABLE FOR ANY DIRECT, INDIRECT,

INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT

LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR

PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF

LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE

OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF

ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
defined('ABSPATH') or die("Cannot access pages directly."); 

class Shirshak_Note_Children extends wp_widget{
	public function __construct(){
		parent::__construct("Note_Sidebar",__('Browse Notes', 'Shirshak'),["Description"=>"This widget display the children of current post that vistor are browsing"]);
	}
	public function form( $instance ) {
		print_r($instance);
    	extract($instance);
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	</p>
	<p>
        <label for="<?php echo $this->get_field_id( 'depth' ); ?>">Depth of list:</label>
        <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'depth' ); ?>" name="<?php echo $this->get_field_name( 'depth' ); ?>" value="<?php echo esc_attr( $depth ); ?>">
    </p>
	<?php
    }
 	public function update( $new_instance, $old_instance ) {        
         
        $instance = $old_instance;
         
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['depth'] = strip_tags( $new_instance['depth'] );
         
        return $instance;
         
    }
 
    public function widget( $args, $instance ) {
        global $post;
    	extract($args);
    	extract($instance);
    	$title=apply_filters("widget-title",$title);
        $post_type=get_post_type( $post->ID );
    	if(is_singular($post_type)):
	    	echo "\n";
	    	echo $before_widget."\n";
	    		echo $before_title.$title.$after_title."\n";
	    		 $this->get_notes_childrens($post_type);
	    	echo $after_widget."\n";
    	endif;
    }
    public function get_notes_childrens($post_type){
    	global $post;
    	wp_list_pages(['post_type'=>$post_type,'title_li'=> __(''),'depth'=>3]);
	}

}
add_action("widgets_init",function(){
	register_widget("Shirshak_Note_Children");
});