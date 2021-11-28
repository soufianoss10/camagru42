<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row" >
    <div class="col-md-6 mx-auto">
         <div class="card card-body bg-light mb-4"> <h2>Create An Account</h2>
            <p>Please fill out this form to Register in Our Site! </p>
            <form action="<?php echo URLROOT; ?>/users/register" method="POST" >
                <div class="form-group mt-3">
                    <label for="name">Name: <sup>*</sup> </label>
                    <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_error'])) ? 'is-invalid' : ''; ?>" value="<?= $data['name'];?>" > 
                    <span class="invalid-feedback"><?php echo $data['name_error']; ?></span>        
                </div>

                <div class="form-group mt-6">
                    <label for="email">Email: <sup>*</sup> </label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?= $data['email'];?>" > 
                    <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>        
                </div>

                <div class="form-group mt-3">
                    <label for="password">Password: <sup>*</sup> </label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" value="<?= $data['password'];?>" > 
                    <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>      
                </div>

                <div class="form-group mt-3" >
                    <label for="confirm_password">Confirm Password: <sup>*</sup> </label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_error'])) ? 'is-invalid' : ''; ?>" value="<?= $data['confirm_password'];?>" > 
                    <span class="invalid-feedback"><?php echo $data['confirm_password_error']; ?></span>        
                </div>


                <div class="row mt-3">

                    <div class= "col">
                        <input type="submit" value="Register" class="btn btn-success btn-block" >
                        <!-- <button type="button" class="btn btn-outline-success">Sign-up</button> -->
                    </div>
                    <div class="col">
                    <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">You Have an account? Login</a>
                    </div>
                </div>
            </form>
         </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>