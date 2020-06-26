<!-- Container -->
<div class="container">

	<div class="my-account">

			<!-- Login -->
				<?php $attributes = array('name' => 'user_signin','id' => 'xin-form',  'autocomplete' => 'on');?>
				<?php $hidden = array('signin' => '1');?>
                <?php echo form_open('employer/login/', $attributes, $hidden);?>

					<p class="form-row form-row-wide">
						<label for="eemail">Email:
							<i class="ln ln-icon-Male"></i>
							<input type="text" class="input-text" name="email" />
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="epassword">Password:
							<i class="ln ln-icon-Lock-2"></i>
							<input class="input-text" type="password" name="password"/>
						</label>
					</p>

					<p class="form-row">
						<input type="submit" class="button border fw margin-top-10 save" name="login" value="Login" />
					</p>

					<p class="lost_password">
						<a href="<?php echo site_url('employer/forgot_password');?>" >Lost Your Password?</a>
					</p>
					
				<?php echo form_close(); ?>
			
	</div>
</div>