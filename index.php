<?php
/*
Plugin Name: Галлерея TootKot
Plugin URI: https://github.com/genius22222/tok-gallery
Description: Плагин галлереи для темы TootKot-v-2-0
Version: 1.0
Author: Alexander Archibasov
Author URI: https://vk.com/id89802582
*/


register_activation_hook(__FILE__, 'tok-activate');  //Регистрируем функцию активатор
add_action('admin_init', 'tok_init', 1);
add_action('admin_enqueue_scripts', 'tok_connect_scripts');

function tok_activate(){
	global $wpdb;
	$wpdb->get_results('ALTER TABLE `wp_terms` ADD `tok_image` TEXT NOT NULL AFTER `term_group`');
}
function tok_init(){
	add_action('category_edit_form_fields', 'tok_category_custom_fields', 10, 2);
	add_action('edited_category', 'tok_cat_save');

}
function tok_connect_scripts(){
	wp_enqueue_media();
	wp_register_script('tok_upload', plugins_url('tok-upload.js', __FILE__));
	wp_enqueue_script('tok_upload', array('jquery'));
}
function tok_category_custom_fields($terms, $taxonomy){?>

	<tr class="form-field">
		<th scope="row">
			<label for="tok_image_box">Картинка:</label>
		</th>
		<td>
			<input type="hidden" id="tok_send_image" name="tok_image" value="">
			<input type="button" value="Добавить картинку" id="tok_add_image_button">
			<input type="button" value="Удалить картинку" id="tok_remove_image_button">

            <?php

            ?>


			<img src="<?php //plugins_url('default.png', __FILE__) ?>">
			<p class="description">Загрузите картинку с помощью этих кнопок, а настройки расположения задайте в настройках плагина.</p>
		</td>
	</tr>
<?php

}

function tok_cat_save(){
	global $wpdb;
	$w = $_POST['tok_image'];
	$wpdb->get_results('ALTER TABLE `wp_terms` ADD `'.$w.'` TEXT NOT NULL AFTER `term_group`');
}