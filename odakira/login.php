<?php
	$pageTitle = "Login";

	include_once "includes/header.php"
?>
<?php 
	if(!empty($_POST))
	{
		echo "POSTED MF";
		//validate
		$errors = [];
		
		$query = "select * from users where email = :email limit 1";
		$row = query($query, ['email'=>$_POST['email']]);
		
		if($row)
		{
			$data = [];
			if(password_verify($_POST['password'], $row[0]['password']))
			{
				//grant access
				authenticate($row[0]);
				redirect('admin');
			
			}
			else
			{
			  $errors['email'] = "wrong email or password";
			}
		
		}
		else
		{
		  	$errors['email'] = "wrong email or password";
		}
	}
?>

	<section class="vh-100" style="background-color: #00008B;">
	  <div class="container py-5 h-100">
	    <div class="row d-flex justify-content-center align-items-center h-100">
	      <div class="col col-xl-10">
	        <div class="card" style="border-radius: 1rem;">
	          <div class="row g-0">
	            <div class="col-md-6 col-lg-5 d-none d-md-block">
	              <img src="assets/images/login.webp"
	                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
	            </div>
	            <div class="col-md-6 col-lg-7 d-flex align-items-center">
	              <div class="card-body p-4 p-lg-5 text-black">

	                <form method="post">

	                  <!-- <div class="d-flex align-items-center mb-3 pb-1">
	                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
	                    <span class="h1 fw-bold mb-0">Logo</span>
	                  </div> -->

	                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

	                  <div data-mdb-input-init class="form-outline mb-4">
	                    <input name="email" type="email" class="form-control form-control-lg" required />
	                    <label class="form-label" for="form2Example17">Email address</label>
	                  </div>

	                  <div data-mdb-input-init class="form-outline mb-4">
	                    <input name="password" type="password" class="form-control form-control-lg" required />
	                    <label class="form-label" for="form2Example27">Password</label>
	                  </div>

					  <!-- Checkbox -->
              		  <div class="form-check d-flex justify-content-center mb-4">
              		    <input name="remember-me" class="form-check-input me-2" type="checkbox" value="" id="form2Example33" required />
              		    <label class="form-check-label" for="form2Example33">
              		      Remember me
              		    </label>
              		  </div>

	                  <div class="pt-1 mb-4">
	                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="button">Login</button>
	                  </div>

	                  <a class="small text-muted" href="#!">Forgot password?</a>
	                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="signup"
	                      style="color: #393f81;">Register here</a></p>
	                  <a href="#!" class="small text-muted">Terms of use.</a>
	                  <a href="#!" class="small text-muted">Privacy policy</a>
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
	include_once "includes/footer.php"
?>