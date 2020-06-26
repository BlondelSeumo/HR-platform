<div class="container">
  <div class="my-account">
    <?php $attributes = array('name' => 'login', 'id' => 'xin-form', 'class' => 'password', 'autocomplete' => 'on');?>
	<?php $hidden = array('login' => '1');?>
    <?php echo form_open('employer/update_password/', $attributes, $hidden);?>
      <p class="form-row form-row-wide">
        <label for="username">New Password <i class="ln ln-icon-Lock"></i>
          <input type="password" class="input-text" name="new_password" id="new_password" value="" />
        </label>
      </p>
      <p class="form-row form-row-wide">
        <label for="username">Confirm New Password <i class="ln ln-icon-Lock"></i>
          <input type="password" class="input-text" name="new_password_confirm" id="new_password_confirm" value="" />
        </label>
      </p>
      <p class="form-row">
        <input type="submit" class="button border fw margin-top-10" name="login" value="Change Password" />
      </p>
    </form>
  </div>
</div>
