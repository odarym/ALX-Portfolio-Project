<?php 
	// FIX: Process login authentication form BEFORE sending HTML headers to allow clean header redirects
	if(!empty($_POST))
	{
		// Validate credentials
		$errors = [];
		
		$query = "select * from users where email = :email limit 1";
		$row = query($query, ['email'=>$_POST['email']]);
		
		if (!empty($GLOBALS['DB_LAST_ERROR']))
		{
			$errors['email'] = "Unable to connect to MySQL database server (localhost:3306). Please ensure MySQL or MariaDB is running.";
		}
		else if($row)
		{
			if(password_verify($_POST['password'], $row[0]['password']))
			{
				// Grant access and store user session
				authenticate($row[0]);
				redirect('admin');
			}
			else
			{
				$errors['email'] = "Wrong email or password";
			}
		}
		else
		{
			$errors['email'] = "Wrong email or password";
		}
	}

	$pageTitle = "Login";
	include_once "includes/header.php";
?>

	<!-- FIX: Replaced hardcoded style="background-color: #00008B;" with Bootstrap 5.3 theme-aware class "bg-body-tertiary" so the background adapts seamlessly to Light and Dark modes -->
	<section class="min-vh-100 bg-body-tertiary d-flex align-items-center py-5">
	  <div class="container h-100">
	    <div class="row d-flex justify-content-center align-items-center h-100">
	      <div class="col col-xl-10">
	        <!-- FIX: Added "shadow-lg border-0 bg-body" to card so card background adapts to dark mode theme variables -->
	        <div class="card shadow-lg border-0 bg-body" style="border-radius: 1rem;">
	          <div class="row g-0">
	            <div class="col-md-6 col-lg-5 d-none d-md-block">
	              <img src="assets/images/login.webp"
	                alt="login form" class="img-fluid h-100" style="border-radius: 1rem 0 0 1rem; object-fit: cover;" />
	            </div>
	            <div class="col-md-6 col-lg-7 d-flex align-items-center">
	              <!-- FIX: Replaced "text-black" with "text-body" so text color automatically inverts to light in dark mode -->
	              <div class="card-body p-4 p-lg-5 text-body">

	                <form method="post">

	                  <!-- FIX: Added "text-body-emphasis" for high contrast heading in both themes -->
	                  <h5 class="fw-bold mb-3 pb-3 text-body-emphasis" style="letter-spacing: 1px;">Sign into your account</h5>

	                  <!-- FIX: Render error notification when authentication fails -->
	                  <?php if (!empty($errors['email'])): ?>
	                    <div class="alert alert-danger py-2 mb-3"><?= esc($errors['email']) ?></div>
	                  <?php endif; ?>

	                  <div data-mdb-input-init class="form-outline mb-4">
	                    <!-- FIX: Retain previous email input on failed attempt -->
	                    <input value="<?= old_value('email') ?>" name="email" type="email" class="form-control form-control-lg bg-body text-body" required />
	                    <!-- FIX: Added "text-body" to label for theme responsiveness -->
	                    <label class="form-label text-body" for="form2Example17">Email address</label>
	                  </div>

	                  <div data-mdb-input-init class="form-outline mb-4">
	                    <input name="password" type="password" class="form-control form-control-lg bg-body text-body" required />
	                    <!-- FIX: Added "text-body" to label for theme responsiveness -->
	                    <label class="form-label text-body" for="form2Example27">Password</label>
	                  </div>

					  <!-- Checkbox: FIX: Removed 'required' attribute so Remember Me is optional -->
              		  <div class="form-check d-flex justify-content-start mb-4">
              		    <input name="remember-me" class="form-check-input me-2" type="checkbox" id="form2Example33" />
              		    <!-- FIX: Added "text-body" to remember me label -->
              		    <label class="form-check-label text-body" for="form2Example33">
              		      Remember me
              		    </label>
              		  </div>

	                  <!-- FIX: Changed button type from 'button' to 'submit' and applied primary theme button style -->
	                  <div class="pt-1 mb-4">
	                    <button class="btn btn-primary btn-lg w-100 fw-semibold" type="submit">Login</button>
	                  </div>

	                  <!-- FIX: Replaced hardcoded text-muted with Bootstrap 5.3 text-body-secondary -->
	                  <a class="small text-body-secondary d-block mb-3" href="#!">Forgot password?</a>
	                  <!-- FIX: Replaced hardcoded style="color: #393f81;" with text-body-secondary and link-primary -->
	                  <p class="mb-4 pb-lg-2 text-body-secondary">Don't have an account? <a href="signup" class="link-primary fw-semibold">Register here</a></p>
	                  <!-- FIX: Replaced hardcoded text-muted with text-body-secondary -->
	                  <a href="#!" class="small text-body-secondary me-3">Terms of use.</a>
	                  <a href="#!" class="small text-body-secondary">Privacy policy</a>
	                </form>

	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</section>

<?php
	include_once "includes/footer.php";
?>