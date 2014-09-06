<?php
if( isset( $_GET['page'] ) ){
	//echo $_GET['page']; 
	$url = $_GET['page']; // TO DO: ADD SOME SECURITY CHECKING HERE
	$json = file_get_contents( $url.'?json=true');
	$post_data = json_decode( $json );
	if( $post_data ){
		foreach( $post_data as $post_item ){
			echo $post_item->html;
		}
	}
} else {
	//echo '';
}
?>