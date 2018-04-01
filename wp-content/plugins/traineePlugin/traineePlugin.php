<?php
/*
Plugin Name: Trainee Plugin
Description: Плагин созданный для выполнения задания
Version: 1.0
Author: Александр Трюхан
*/
//movies_tax

add_action("the_content", "movie_info_display");
function movie_info_display($content)
{
	if (is_single()) {
		$custom = get_post_custom();
		$taxs = get_the_terms(get_the_ID(),'movies_tax');
		$countries = array();
		$actors = array();
		foreach ($taxs as $tax) {
			$parentID = $tax->parent;
			if ($parentID == 3) {
				array_push($countries,$tax->name);
			}
			if ($parentID == 5) {
				array_push($actors,$tax->name);
			}
		}
		echo "<p><b>Страна: </b>";
		foreach ($countries as $country) {
			echo $country;
			if ($country !== end($countries)) {
				echo ", ";
			}
		}
		echo "</p>";
		echo "<p><b>Актеры: </b>";
		foreach ($actors as $actor) {
			echo $actor;
			if ($actor !== end($actors)) {
				echo ", ";
			}
		}
		echo "</p>";
		$info = "<p><b>Стоимость: </b>".$custom['order'][0]."</p><p><b>Дата выхода: </b>".$custom['kind'][0]."</p>";
		return $content . $info;
	} else {
		return $content;
	}
}
?>