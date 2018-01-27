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
	add_action('category_edit_form_fields', 'tok_category_update_custom_fields', 10, 2);
	add_action('category_add_form_fields', 'tok_category_create_custom_fields');
	add_action('create_term', 'tok_cat_create');
	add_action('edit_term', 'tok_cat_update');
}
function tok_connect_scripts(){
	wp_enqueue_media();
	wp_register_script('tok_upload', plugins_url('tok-upload.js', __FILE__));
	wp_enqueue_script('tok_upload', array('jquery'));
	wp_localize_script('tok_upload', 'tok_default_image', array('img' => plugins_url('default.png', __FILE__)));
	wp_register_script('tok_fix', plugins_url('tok-fix.js', __FILE__));
	wp_enqueue_script('tok_fix', array('jquery'));
}
function tok_category_update_custom_fields($terms, $taxonomy){?>

	<tr class="form-field">
		<th scope="row">
			<label for="tok_image_box">Картинка:</label>
		</th>
		<td>
			<input type="button" value="Добавить картинку" id="tok_add_image_button">
			<input type="button" value="Удалить картинку" id="tok_remove_image_button">
            <input type="hidden" value="" name="tok_image" id="tok_image">
            <?php
            global $wpdb;
            $image_url = plugins_url('default.png', __FILE__);
            $getImage = $terms->tok_image;
            if ($getImage){
                $image_url = $getImage;
            }
            ?>

            <br><img id="tok_preview_image" src="<?php echo $image_url ?>" width="200" height="200" style="margin-top: 15px;">
			<p class="description">Загрузите картинку с помощью этих кнопок, а настройки расположения задайте в настройках плагина.</p>
		</td>
	</tr>
<?php

}

function tok_category_create_custom_fields($terms){ ?>
    <tr class="form-field">
        <th scope="row">
            <label for="tok_image_box">Картинка:</label>
        </th>
        <td>
            <input type="button" value="Добавить картинку" id="tok_add_image_button">
            <input type="button" value="Удалить картинку" id="tok_remove_image_button">
            <input type="hidden" value="" name="tok_image" id="tok_image">
			<?php
			global $wpdb;
			$image_url = plugins_url('default.png', __FILE__);
			$getImage = $terms->tok_image;
			if ($getImage){
				$image_url = $getImage;
			}
			?>

            <br><img id="tok_preview_image" src="<?php echo $image_url ?>" width="200" height="200" style="margin-top: 15px;">
            <p class="description">Загрузите картинку с помощью этих кнопок, а настройки расположения задайте в настройках плагина.</p>
        </td>
    </tr>

    <?php
}

function tok_cat_update(){
	global $wpdb;
	if ($_POST['tok_image'] && $_POST['tok_image'] !== 'delete'){
		if ($_POST['tok_image'] == 'delete'){
			$wpdb->update( 'wp_terms', array(
				'tok_image' => ''
			), array( 'name' => $_POST['name'] ) );
        } else {
			$wpdb->update( 'wp_terms', array(
				'tok_image' => $_POST['tok_image']
			), array( 'name' => $_POST['name'] ) );
		}
    }
}

function tok_cat_create(){
	global $wpdb;
	if ($_POST['tok_image'] && $_POST['tok_image'] !== 'delete'){
		$wpdb->update('wp_terms', array(
			'tok_image' => $_POST['tok_image']
		), array('name' => $_POST['tag-name']));
	}
}