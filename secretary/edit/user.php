<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "users";

include $baseUrl . "assets/templates/secretary/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Edit User</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="../">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="card">
    <form class="card-body" action="../../assets/includes/secretary/user.inc.php" method="POST">
        
        <?php
        
        $userId = sanitize($_GET["userId"]);
        
        $sql = "SELECT * FROM users WHERE id = '$userId'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
        	while ($row = mysqli_fetch_assoc($result)) {
        	   echo "<input type='hidden' name='userId' value='" . $userId . "'>
        	   
        	   <div class='row'>
                    <div class='col-md-6'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <div class='mb-3'>
                					<label>Institute</label>
                					<input class='form-control form-control-lg' type='text' name='institute' value='" . $row["institute"] . "'>
                				</div>
                			</div>
                			
                			<div class='col-md-4'>
                                <div class='mb-3'>
                					<label>Role</label>
                					<input class='form-control form-control-lg' type='text' name='role' value='" . $row["role"] . "' required>
                				</div>
                			</div>
                			
                			<div class='col-md-4'>
                                <div class='mb-3'>
                					<label>Status</label>
                					<input class='form-control form-control-lg' type='text' name='status' value='" . $row["status"] . "'>
                				</div>
                			</div>
                		</div>
                		
                		<div class='row'>
                            <div class='col-md-4'>
                                <div class='mb-3'>
                					<label>Username</label>
                					<input class='form-control form-control-lg' type='text' name='username' value='" . $row["username"] . "' readonly>
                				</div>
                			</div>
                			
                			<div class='col-md-8'>
                                <div class='mb-3'>
                					<label>Email Address</label>
                					<input class='form-control form-control-lg' type='text' name='emailAddress' value='" . $row["email_address"] . "'>
                				</div>
                			</div>
                		</div>
                    </div>
                    
                    <div class='col-md-6'>
                        <div class='mb-3'>
        					<label>First Name</label>
        					<input class='form-control form-control-lg' type='text' name='firstname' value='" . $row["firstname"] . "' required>
        				</div>
                    
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='mb-3'>
                					<label>Middle Name</label>
                					<input class='form-control form-control-lg' type='text' name='middlename' value='" . $row["middlename"] . "'>
                				</div>
                			</div>
                			
                			<div class='col-md-6'>
                                <div class='mb-3'>
                					<label>Last Name</label>
                					<input class='form-control form-control-lg' type='text' name='lastname' value='" . $row["lastname"] . "' required>
                				</div>
                			</div>
                		</div>
                    </div>
                </div>
                
                <div class='mb-3'>
					<label class='form-check user-select-none'>
						<input class='form-check-input' type='checkbox' required>
						<span class='form-check-label'>Verify</span>
					</label>
				</div>

				<div class='text-center'>
					<button class='btn btn-success btn-lg' type='submit' name='submitEditUser'>
						Submit
					</button>
				</div>";
        	}
        }
            
        ?>
        
    </form>
</div>

<?php

include $baseUrl . "assets/templates/secretary/footer.inc.php";

?>