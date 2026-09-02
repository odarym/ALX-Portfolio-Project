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
      // Save user to database
      $data = [];
      $data['username'] = $_POST['username'];
      $data['email']    = $_POST['email'];
      $data['role']     = "user";
      $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // FIX: Removed debug output `print_r($data['username']);`

      $query = "insert into users (username,email,password,role) values (:username,:email,:password,:role)";
      $res = query($query, $data);

      if (!empty($GLOBALS['DB_LAST_ERROR'])) {
          $errors['email'] = "Unable to connect to MySQL database server (localhost:3306). Please ensure MySQL or MariaDB is running.";
      } else {
          redirect('login');
      }
    }

  }
?>
<?php
	$pageTitle = "Sign Up";

	include_once "includes/header.php"
?>

<!-- FIX: Replaced hardcoded style="background-color: #00008B;" with Bootstrap 5.3 theme-aware "bg-body-tertiary" -->
<section class="text-center text-lg-start bg-body-tertiary py-5">
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
        <!-- FIX: Updated card to use "bg-body shadow-lg border-0" for theme-aware dark background -->
        <div class="card cascading-right bg-body shadow-lg border-0" style="backdrop-filter: blur(30px);">
          <div class="card-body p-5 shadow-5 text-center text-body">
            <!-- FIX: Added "text-body-emphasis" for theme-aware heading contrast -->
            <h2 class="fw-bold mb-4 text-body-emphasis">Sign up now</h2>
            <form method="post">
				<?php if (!empty($errors)):?>
					<div class="alert alert-danger">Please fix the errors below</div>
				<?php endif;?>

				
				<?php if(!empty($errors['username'])):?>
					<div class="text-danger small mb-1"><?= esc($errors['username']) ?></div>
				<?php endif;?>
				<!-- Username input -->
				<div data-mdb-input-init class="form-outline mb-4">
				<!-- FIX: Added bg-body and text-body classes -->
				<input value="<?=old_value('username')?>" name="username" type="text" class="form-control bg-body text-body" required />
				<!-- FIX: Added text-body to label -->
				<label class="form-label text-body">Username</label>
				</div>


				<?php if(!empty($errors['email'])):?>
    				<div class="text-danger small mb-1"><?= esc($errors['email']) ?></div>
    			<?php endif;?>
				<!-- Email input -->
				<div data-mdb-input-init class="form-outline mb-4">
				<!-- FIX: Added bg-body and text-body classes -->
				<input value="<?=old_value('email')?>" name="email" type="email" class="form-control bg-body text-body" required />
				<!-- FIX: Added text-body to label -->
				<label class="form-label text-body">Email address</label>
				</div>

				
				<?php if(!empty($errors['password'])):?>
					<div class="text-danger small mb-1"><?= esc($errors['password']) ?></div>
				<?php endif;?>
				<!-- Password input -->
				<div data-mdb-input-init class="form-outline mb-4">
					<!-- FIX: Added bg-body and text-body classes -->
					<input value="<?=old_value('password')?>" name="password" type="password" class="form-control bg-body text-body" required />
					<!-- FIX: Added text-body to label -->
					<label class="form-label text-body" for="form3Example4">Password</label>
				</div>


				<!-- Password re-input -->
				<div data-mdb-input-init class="form-outline mb-4">
				<!-- FIX: Added bg-body and text-body classes -->
				<input value="<?=old_value('retype_password')?>" name="retype_password" type="password" class="form-control bg-body text-body" required />
				<!-- FIX: Added text-body to label -->
				<label class="form-label text-body" for="form3Example4">Confirm password</label>
				</div>

				<?php if(!empty($errors['terms'])):?>
    				<div class="text-danger small mb-1"><?= esc($errors['terms']) ?></div>
    			<?php endif;?>
				<!-- Checkbox -->
				<div class="form-check d-flex justify-content-center mb-4">
				<input name="terms" class="form-check-input me-2" type="checkbox" value="remember-me" id="form2Example33" required />
				<!-- FIX: Added text-body to terms label -->
				<label class="form-check-label text-body" for="form2Example33">
					Accept OdaKira terms and conditions
				</label>
				</div>

				<!-- Submit button -->
				<button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block w-100 mb-4 fw-semibold">
				Sign up
				</button>

				<!-- FIX: Replaced hardcoded style="color: #393f81;" with text-body-secondary and link-primary -->
				<p class="mb-4 pb-lg-2 text-body-secondary">Already have an account? <a href="login" class="link-primary fw-semibold">Login here</a></p>

				<!-- Register buttons -->
				<div class="text-center">
				<button  type="button" class="btn btn-link text-body-secondary btn-floating mx-1">
					<i class="bi bi-facebook"></i>
				</button>

				<button  type="button" class="btn btn-link text-body-secondary btn-floating mx-1">
					<i class="bi bi-google"></i>
				</button>

				<button  type="button" class="btn btn-link text-body-secondary btn-floating mx-1">
					<i class="bi bi-twitter"></i>
				</button>

				<button  type="button" class="btn btn-link text-body-secondary btn-floating mx-1">
					<i class="bi bi-github"></i>
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