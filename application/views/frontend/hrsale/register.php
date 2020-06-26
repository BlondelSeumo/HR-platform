<div class="container">

	<div class="my-account">

		<div class="tabs-container">
			<!-- Register -->
			<div class="tab-content" id="tab2">

                <?php $attributes = array('id' => 'xin-form', 'class' => 'register', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
                <?php echo form_open('employer/create_account/', $attributes, $hidden);?>					
				<p class="form-row form-row-wide">
					<label for="first_name">Company Name:
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="company_name" id="company_name1" value="" />
					</label>
				</p>
                
                <p class="form-row form-row-wide">
					<label for="first_name">First Name:
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="first_name" id="first_name1" value="" />
					</label>
				</p>
                <input type="hidden" name="hrsale_view" value="1" />
				<p class="form-row form-row-wide">
					<label for="last_name">Last Name:
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="last_name" id="last_name1" value="" />
					</label>
				</p>	
				<p class="form-row form-row-wide">
					<label for="email2">Email Address:
						<i class="ln ln-icon-Mail"></i>
						<input type="text" class="input-text" name="email" id="email1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="password1">Password:
						<i class="ln ln-icon-Lock-2"></i>
						<input class="input-text" type="password" name="password" id="password1"/>
					</label>
				</p>
                <p class="form-row form-row-wide">
					<label for="contact_number">Contact Number:
						<i class="ln ln-icon-Phone-2"></i>
						<input type="text" class="input-text" name="contact_number" id="contact_number1" value="" />
					</label>
				</p>
                <p class="form-row">
                    <h5>Logo</h5>
                    <label class="upload-btn">
                        <input type="file" id="company_logo" name="company_logo" />
                        Browse
                    </label>
                </p>
				<p class="form-row">
					<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
				</p>

				</form>
			</div>
		</div>
	</div>
</div>

<!-- Container -->