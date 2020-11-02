<div class="container login-container">
    <div class="row">
         <div class="col-md-12">
             <?php if ($this->session->flashdata('flasherror')) { ?>
            <div class="error alert alert-danger"> <?php echo $this->session->flashdata('flasherror'); ?> </div>
            <?php } ?>
            <?php if ($this->session->flashdata('flashsuccess')) { ?>
            <div class="error alert alert-success"> <?php echo $this->session->flashdata('flashsuccess'); ?> </div>
            <?php } ?>
        </div>
        <div class="col-md-6 login-form-1">
            <h3>Login</h3>
            <?php $login_form=array('name'=>'login','onsubmit' => 'return login_form()');
                echo  form_open("entry/login",$login_form);?>
                <div class="error" id="login_error"></div>
                <div class="form-group">
                    <input type="email" class="form-control" name="login_email" id="login_email" placeholder="Your Email *" autocomplete="on" value="" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="login_password" id="login_password" placeholder="Your Password *" autocomplete="login_email" value="" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" name="login_submit" value="Login" />
                </div>
            <?php echo form_close();?>
        </div>
        <div class="col-md-6 register-form-2">
            <h3>Register</h3>
            <?php $registration_form=array('name'=>"registration","autocomplete"=>"off",'onsubmit' => 'return registration_form()');
                echo form_open("entry/registration",$registration_form);?>
                <div class="error" id="registration_error"></div>
                <div class="form-group">
                    <input type="text" class="form-control" name="registration_email" id="registration_email" placeholder="Your Email *" autocomplete="off" value="" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="registration_password" id="registration_password" placeholder="Your Password *" autocomplete="off" value="" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" name="registration_submit" value="Register" />
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>