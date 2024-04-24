<?php

function change_password_form() { ?>
<form class="change_password_form woocommerce-EditAccountForm edit-account edit-account-form" action="" method="post">
    <div class="woocommerce-address-fields">
        <div class="woocommerce-address-fields__field-wrapper">
            <p class="woocommerce-form-row woocommerce-form-row form-row">
                <label for="current_password"><?= __("Actual password", 'inoby') ?></label>
                <input id="current_password" class="input-text" type="password" name="current_password"
                    title="current_password" placeholder="<?= __("Actual password", 'inoby') ?>" required>

            </p>

            <p class="woocommerce-form-row woocommerce-form-row form-row">
                <label for="new_password"><?= __("New password", 'inoby') ?></label>
                <input id="new_password" type="password" name="new_password" title="new_password"
                    placeholder="<?= __("New password", 'inoby') ?>" required>
            </p>

            <p class="woocommerce-form-row woocommerce-form-row form-row">
                <label for="confirm_new_password"><?= __("New password again", 'inoby') ?></label>
                <input id="confirm_new_password" type="password" name="confirm_new_password"
                    title="confirm_new_password" placeholder="<?= __("New password again", 'inoby') ?>" required>
            </p>
            <p class="form-submit">
                <button class="woocommerce-Button button triangleleft triangleright"
                    type="submit"><?= __("Potvrdiť", 'inoby') ?></button>
            </p>
        </div>
    </div>

</form>
<?php }

function change_password(){
	if(isset($_POST['current_password'])){
		$_POST = array_map('stripslashes_deep', $_POST);
		$current_password = sanitize_text_field($_POST['current_password']);
		$new_password = sanitize_text_field($_POST['new_password']);
		$confirm_new_password = sanitize_text_field($_POST['confirm_new_password']);
		$user_id = get_current_user_id();
		$errors = array();
		$current_user = get_user_by('id', $user_id);
		// Check for errors
		if (empty($current_password) && empty($new_password) && empty($confirm_new_password) ) {
		$errors[] = __("Please fill all required fields", 'inoby');
		}
		if($current_user && wp_check_password($current_password, $current_user->data->user_pass, $current_user->ID)){
		//match
		} else {
			$errors[] = __("Old password is not right", 'inobys');
		}
		if($new_password != $confirm_new_password){
			$errors[] = __("Passwords do not match", 'inoby');
		}
		if(strlen($new_password) < 6){
			$errors[] = __("Password is too short, us at least 6 characters", 'inoby');
		}
		if(empty($errors)){
			wp_set_password( $new_password, $current_user->ID );
			echo '<h4>'.__("Password was changed successfuly").'</h4>';
		} else {
			// Echo Errors
		    foreach($errors as $error){
		        echo '<p class="error-message">';
		        echo "<strong>$error</strong>";
		        echo '</p>';
		    }
		}
    }
}

function cp_form_shortcode(){
	    change_password();
        change_password_form();
}
add_shortcode('changepassword_form', 'cp_form_shortcode');