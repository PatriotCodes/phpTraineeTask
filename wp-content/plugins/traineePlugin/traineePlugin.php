<?php
/*
Plugin Name: Trainee Plugin
Description: Плагин созданный для выполнения задания
Version: 1.0
Author: Александр Трюхан
*/

add_action("the_content", "movie_info_display");
function movie_info_display($content)
{
	if (is_single()) {
	$custom = get_post_custom();
    $info = "<p><b>Стоимость: </b>".$custom['order'][0]."</p><p><b>Дата выхода: </b>".$custom['kind'][0]."</p>";
    return $content . $info;
	} else {
		return $content;
	}
}
?>