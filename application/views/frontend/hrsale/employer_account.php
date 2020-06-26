<!-- Container -->

<div class="container">
  <?php $attributes = array('name' => 'register', 'id' => 'xin-form', 'class' => 'login', 'autocomplete' => 'on');?>
	<?php $hidden = array('update' => '1');?>
    <?php echo form_open('employer/update_account/', $attributes, $hidden);?>
    <div class="eight columns">
      <p class="form-row form-row-wide">
        <label for="first_name">First Name
          <input type="text" class="input-text" name="first_name" id="first_name" value="<?php echo $first_name;?>" />
        </label>
      </p>
      <p class="form-row form-row-wide">
        <label for="company_name">Company  Name
          <input type="text" class="input-text" name="company_name" id="company_name" value="<?php echo $company_name;?>" />
        </label>
      </p>
      
      <p class="form-row form-row-wide">
        <label for="email2">Email Address
          <input type="text" class="input-text" name="email" id="email2" value="<?php echo $email;?>" />
        </label>
      </p>
      <p class="form-row form-row-wide">
        <label for="contact_number">Contact Number
          <input type="text" class="input-text" name="contact_number" id="contact_number" value="<?php echo $contact_number;?>" />
        </label>
      </p>
      <p class="form-row">
            <div class="select">
                <label for="gender">Gender
                <select data-placeholder="Select Gender" name="gender" class="chosen-select">
                    <option value=""></option>
                    <option value="Male" <?php if($gender=='Male'):?> selected="selected"<?php endif;?>>Male</option>
                    <option value="Female" <?php if($gender=='Female'):?> selected="selected"<?php endif;?>>Female</option>
                </select>
               </label> 
            </div>
      </p>
      <p class="form-row">
        <h5>Company Logo</h5>
        <label class="upload-btn">
            <input type="file" id="company_logo" name="company_logo" />
            <i class="fa fa-upload"></i> Browse
        </label>
        <img src="<?php echo base_url('uploads/employers/').$company_logo;?>" width="80" height="80" />
    </p>
    </div>
    <div class="eight columns">
      <p class="form-row form-row-wide">
        <label for="last_name">Last Name
          <input type="text" class="input-text" name="last_name" id="last_name" value="<?php echo $last_name;?>" />
        </label>
      </p>
      <p class="form-row form-row-wide">
        <label for="username2">Address
          <input type="text" class="input-text" placeholder="Address Line 1" name="address_1" id="address_1" value="<?php echo $address_1;?>" />
          <br /><input type="text" class="input-text" placeholder="Address Line 2" name="address_2" id="address_2" value="<?php echo $address_2;?>" />
        </label>
      </p>
      <p class="form-row form-row-wide">
          <input type="text" class="input-text" name="city" id="city" placeholder="City" value="<?php echo $city;?>"/><br />
          <input type="text" class="input-text" name="state" id="state" placeholder="State" value="<?php echo $state;?>" /><br />
          <input type="text" class="input-text" name="zipcode" id="zipcode" placeholder="Zip Code" value="<?php echo $zipcode;?>" />
      </p>
      <p class="form-row">
        <div class="select">
            <label for="country">Country
            <select data-placeholder="Select Country" id="country" name="country" class="chosen-select">
                <option value=""></option>
                <?php foreach($all_countries as $country) {?>
                <option value="<?php echo $country->country_id;?>" <?php if($country->country_id==$icountry):?> selected="selected" <?php endif;?>><?php echo $country->country_name;?></option>
                <?php } ?>
            </select>
           </label> 
        </div>
      </p>
      <p class="form-row1">
        <input type="submit" class="button border fw margin-top-10" name="update" value="Update" />
      </p>
    </div>
  </form>
</div>
