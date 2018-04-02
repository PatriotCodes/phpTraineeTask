<?php
/*
Plugin Name: Trainee Plugin
Description: Плагин созданный для выполнения задания
Version: 1.0
Author: Александр Трюхан
*/
//movies_tax

add_action("the_content", "movie_info_display");
add_filter( 'the_title', 'custom_title', 10, 2 );
function movie_info_display($content)
{
	if (is_single()) {
		$custom = get_post_custom();
		$taxs = get_the_terms(get_the_ID(),'movies_tax');
		$countries = array();
		$actors = array();
		$genres = array();
		$info;
		foreach ($taxs as $tax) {
			$parentID = $tax->parent;
			if ($parentID == 2) {
				array_push($genres,$tax->name);
			}
			if ($parentID == 3) {
				array_push($countries,$tax->name);
			}
			if ($parentID == 5) {
				array_push($actors,$tax->name);
			}
		}
		$info = $info."<p><b><span class='glyphicon glyphicon-flag'></span>   </b>";
		foreach ($countries as $country) {
			$info = $info.$country;
			if ($country !== end($countries)) {
				$info = $info.", ";
			}
		}
		$info = $info."</p>";
		$info = $info."<p><b><span class='glyphicon glyphicon-sunglasses'></span>   </b>";
		foreach ($actors as $actor) {
			$info = $info.$actor;
			if ($actor !== end($actors)) {
				$info = $info.", ";
			}
		}
		$info = $info."</p>";
		$info = $info."<p><b><span class='glyphicon glyphicon-eye-open'></span>   </b>";
		foreach ($genres as $genre) {
			$info = $info.$genre;
			if ($genre !== end($genres)) {
				$info = $info.", ";
			}
		}
		$info = $info."</p>";
		return $content . $info;
	} else {
		return $content;
	}
}

function custom_title($title, $post_id) {
	if ($post_id != null) {
		$custom = get_post_meta($post_id);
		if ($custom['order'][0] != null && $custom['kind'][0] != null) {
			$info = "<p><h5><span class='glyphicon glyphicon-tag'></span>  <span class='label label-info'>".$custom['order'][0]."</span></h5></p><p><h5><span class='glyphicon glyphicon-calendar'></span>  <span class='label label-info'>".$custom['kind'][0]."</span></h5></p>";
			return $title.$info;
		} else {
			return $title;
		}
	} else {
		return $title;
	}
}
?>