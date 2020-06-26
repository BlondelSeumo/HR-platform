<!-- Container -->
<div class="container">

	<div class="my-account">

		<div class="tabs-container">
			<!-- Login -->
			<div class="tab-content" id="tab1">
				<?php
					if($this->session->flashdata('sent_message')):
						echo $this->session->flashdata('sent_message');
					endif;
				?>
				<?php $attributes = array('name' => 'recover_password', 'id' => 'xin-form', 'class' => 'login', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
                <?php echo form_open('employer/send_mail/', $attributes, $hidden);?>

					<p class="form-row form-row-wide">
						<label for="username">Email:
							<i class="ln ln-icon-Mail"></i>
							<input type="text" class="input-text" name="iemail" id="iemail" value="" />
						</label>
					</p>
					<p class="form-row">
						<input type="submit" class="button border fw margin-top-10" name="recover_password" value="Recover Password" />
					</p>

					<p class="lost_password">
						<a href="<?php echo site_url('employer/sign_in');?>" >Remember Password?</a>
					</p>
					
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>