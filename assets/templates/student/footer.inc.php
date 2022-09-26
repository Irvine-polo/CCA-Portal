				</div>
			</main>
		</div>
	</div>

	<input type="hidden" id="baseUrl" value="<?= $baseUrl; ?>">

	<!-- ADMIN KIT JS -->
	<script src="<?= $baseUrl; ?>assets/js/app.js"></script>
	<!-- JQUERY JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<!-- SWEET ALERT JS -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- MAIN JS -->
	<script src="<?= $baseUrl; ?>assets/js/main.js"></script>
	<script type="text/javascript">
		let baseUrl = document.getElementById("baseUrl").value;

		let isImporting = false;

		(function () {
			let idleCounter = 0;

			document.onmousemove = document.onkeypress = function() {
				idleCounter = 0;
			};

			setInterval(function() {
				if (!isImporting) {
					if (++idleCounter >= 180) {
						window.location.href = `${baseUrl}assets/includes/sessions.inc.php?signOut=You've been inactive for a while`;
					}
				} else {
					idleCounter = 0;
				}
			}, 1000);
		}());
	</script>
</body>
</html>
<?php 
		if (isset($_SESSION['attempt'])) {
			$redirect = $_SESSION['redirectURL'];
			?>
					<script type="text/javascript">
						Swal.fire({
						  icon: 'error',
						  title: 'Oops...',
						  text: "You haven't submitted the form yet, please finish the evaluation first before leaving the page.",
						}).then(function() {
						     window.location.href='<?php echo$redirect ?>';
						});
						//alert("Please complete the evaluation form");	

					</script>
			<?php
		}
?>