<?php 

  if(!empty($_POST))
  {
    //validate
    $errors = [];

    if(empty($_POST['username']))
    {
      $errors['username'] = "A username is required";
    }else
    if(!preg_match("/^[a-zA-Z]+$/", $_POST['username']))
    {
      $errors['username'] = "Username can only have letters and no spaces";
    }

    $query = "select id from users where email = :email limit 1";
    $email = query($query, ['email'=>$_POST['email']]);

    if(empty($_POST['email']))
    {
      $errors['email'] = "A email is required";
    }else
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
    {
      $errors['email'] = "Email not valid";
    }else
    if($email)
    {
      $errors['email'] = "That email is already in use";
    }

    if(empty($_POST['password']))
    {
      $errors['password'] = "A password is required";
    }else
    if(strlen($_POST['password']) < 8)
    {
      $errors['password'] = "Password must be 8 character or more";
    }else
    if($_POST['password'] !== $_POST['retype_password'])
    {
      $errors['password'] = "Passwords do not match";
    }

    if(empty($_POST['terms']))
    {
      $errors['terms'] = "Please accept the terms";
    }

    if(empty($errors))
    {
      //save to database
      $data = [];
      $data['username'] = $_POST['username'];
      $data['email']    = $_POST['email'];
      $data['role']     = "user";
      $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

	  print_r($data['username']);

      $query = "insert into users (username,email,password,role) values (:username,:email,:password,:role)";
      query($query, $data);

      redirect('login');

    }
  }
?>
<?php
	$pageTitle = "Sign Up";

	include_once "includes/header.php"
?>

<!-- Section: Design Block -->
<section class="text-center text-lg-start" style="background-color: #00008B;">
  <style>
    .cascading-right {
      margin-right: -50px;
    }

    @media (max-width: 991.98px) {
      .cascading-right {
        margin-right: 0;
      }
    }
  </style>

  <!-- Jumbotron -->
  <div class="container py-4">
    <div class="row g-0 align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <div class="card cascading-right bg-body-tertiary" style="backdrop-filter: blur(30px);">
          <div class="card-body p-5 shadow-5 text-center">
            <h2 class="fw-bold mb-5">Sign up now</h2>
            <form method="post">
				<?php if (!empty($errors)):?>
					<div class="alert alert-danger">Please fix the errors below</div>
				<?php endif;?>

				
				<?php if(!empty($errors['username'])):?>
					<div class="text-danger"><?=$errors['username']?></div>
				<?php endif;?>
				<!-- Username input -->
				<div data-mdb-input-init class="form-outline mb-4">
				<input value="<?=old_value('username')?>" name="username" type="username" class="form-control" required />
				<label class="form-label">Username</label>
				</div>


				<?php if(!empty($errors['email'])):?>
    				<div class="text-danger"><?=$errors['email']?></div>
    			<?php endif;?>
				<!-- Email input -->
				<div data-mdb-input-init class="form-outline mb-4">
				<input value="<?=old_value('email')?>" name="email" type="email" class="form-control" required />
				<label class="form-label">Email address</label>
				</div>

				
				<?php if(!empty($errors['password'])):?>
					<div class="text-danger"><?=$errors['password']?></div>
				<?php endif;?>
				<!-- Password input -->
				<div data-mdb-input-init class="form-outline mb-4">
					<input value="<?=old_value('password')?>" name="password" type="password" class="form-control" required />
					<label class="form-label" for="form3Example4">Password</label>
				</div>


				<!-- Password re-input -->
				<div data-mdb-input-init class="form-outline mb-4">
				<input value="<?=old_value('retype_password')?>" name="retype_password" type="password" class="form-control" required />
				<label class="form-label" for="form3Example4">Confirm password</label>
				</div>

				<?php if(!empty($errors['terms'])):?>
    				<div class="text-danger"><?=$errors['terms']?></div>
    			<?php endif;?>
				<!-- Checkbox -->
				<div class="form-check d-flex justify-content-center mb-4">
				<input name="terms" class="form-check-input me-2" type="checkbox" value="remember-me" id="form2Example33" required />
				<label class="form-check-label" for="form2Example33">
					Accept OdaKira terms and conditions
				</label>
				</div>

				<!-- Submit button -->
				<button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
				Sign up
				</button>

				<p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="login"
				style="color: #393f81;">Login here</a></p>

				<!-- Register buttons -->
				<div class="text-center">
				<button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
					<i class="fab fa-facebook-f"></i>
				</button>

				<button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
					<i class="fab fa-google"></i>
				</button>

				<button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
					<i class="fab fa-twitter"></i>
				</button>

				<button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
					<i class="fab fa-github"></i>
				</button>
				</div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0">
        <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" class="w-100 rounded-4 shadow-4" alt="" />
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->

<?php
	include_once "includes/footer.php"
?>