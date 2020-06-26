<div class="container">
	
	<!-- Submit Page -->
	<div class="sixteen columns">
		<div class="submit-page">
			<?php $attributes = array('name' => 'add_job', 'id' => 'xin-form', 'class' => 'add_job', 'autocomplete' => 'off');?>
				<?php $hidden = array('add_job' => '1');?>
                <?php echo form_open('employer/add_job/', $attributes, $hidden);?>
			<!-- Title -->
			<div class="form">
				<h5>Job Title</h5>
				<input class="search-field" type="text" name="job_title" placeholder="" value=""/>
			</div>

			<!-- Job Type -->
			<div class="form">
				<h5>Job Type</h5>
				<select data-placeholder="Job Type" name="job_type" class="chosen-select-no-single">
					<option value=""></option>
                    <?php foreach($all_job_types->result() as $job_type) {?>
                    <option value="<?php echo $job_type->job_type_id?>"><?php echo $job_type->type?></option>
                    <?php } ?>
				</select>
			</div>


			<!-- Choose Category -->
			<div class="form">
				<div class="select">
					<h5>Category</h5>
					<select id="category_id" name="category_id" data-placeholder="Choose Category" class="chosen-select">
						<option value=""></option>
                        <?php foreach($all_job_categories as $category):?>
                        <option value="<?php echo $category->category_id;?>"><?php echo $category->category_name;?></option>
                        <?php endforeach;?>
					</select>
				</div>
			</div>

			<!-- Description -->
			<div class="form">
				<h5>Short Description</h5>
				<textarea class="" name="short_description" cols="40" rows="1" id="short_description" spellcheck="true"></textarea>
			</div>
            
            <!-- Description -->
			<div class="form">
				<h5>Description</h5>
				<textarea class="WYSIWYG" name="long_description" cols="40" rows="3" id="long_description" spellcheck="true"></textarea>
			</div>
            
            <!-- Vacancy -->
			<div class="form">
				<h5>Number of Positions</h5>
				<input type="text" name="vacancy" placeholder="Enter the job vacancy">
			</div>

			<!-- TClosing Date -->
			<div class="form">
				<h5>Closing Date</h5>
				<input data-role="date" class="date" type="text" name="date_of_closing" placeholder="yyyy-mm-dd">
			</div>

			<!-- Gender -->
			<div class="form">
				<h5>Gender</h5>
				<select data-placeholder="Gender" name="gender" class="chosen-select-no-single">
					<option value="0"><?php echo $this->lang->line('xin_gender_male');?></option>
                    <option value="1"><?php echo $this->lang->line('xin_gender_female');?></option>
                    <option value="2"><?php echo $this->lang->line('xin_job_no_preference');?></option>
				</select>
			</div>
            
            <!-- Experience -->
			<div class="form">
				<h5>Minimum Experience</h5>
				<select data-placeholder="Minimum Experience" name="experience" class="chosen-select-no-single">
					<option value="0"><?php echo $this->lang->line('xin_job_fresh');?></option>
                    <option value="1"><?php echo $this->lang->line('xin_job_experience_define_1year');?></option>
                    <option value="2"><?php echo $this->lang->line('xin_job_experience_define_2years');?></option>
                    <option value="3"><?php echo $this->lang->line('xin_job_experience_define_3years');?></option>
                    <option value="4"><?php echo $this->lang->line('xin_job_experience_define_4years');?></option>
                    <option value="5"><?php echo $this->lang->line('xin_job_experience_define_5years');?></option>
                    <option value="6"><?php echo $this->lang->line('xin_job_experience_define_6years');?></option>
                    <option value="7"><?php echo $this->lang->line('xin_job_experience_define_7years');?></option>
                    <option value="8"><?php echo $this->lang->line('xin_job_experience_define_8years');?></option>
                    <option value="9"><?php echo $this->lang->line('xin_job_experience_define_9years');?></option>
                    <option value="10"><?php echo $this->lang->line('xin_job_experience_define_10years');?></option>
                    <option value="11"><?php echo $this->lang->line('xin_job_experience_define_plus_10years');?></option>
				</select>
			</div>
            <!-- Status -->
			<div class="form">
				<h5>Status</h5>
				<select data-placeholder="Status" name="status" class="chosen-select-no-single">
					<option value="1"><?php echo $this->lang->line('xin_published');?></option>
                    <option value="2"><?php echo $this->lang->line('xin_unpublished');?></option>
				</select>
			</div>

			<div class="divider margin-top-0"></div>
            <button type="submit" class="button big border fw margin-top-10" name="login" />
            <i class="fa fa-arrow-circle-right"></i> Submit</button>

		</form>
		</div>
	</div>

</div>
<div class="margin-top-60"></div>