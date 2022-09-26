				</div>
			</main>
		</div>
	</div>

	<input type="hidden" id="baseUrl" value="<?= $baseUrl; ?>">

	<!-- ADMIN KIT JS -->
	<script src="<?= $baseUrl; ?>assets/js/app.js"></script>
	<!-- JQUERY JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<!-- DATATABLES JS -->
	<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
	<!-- DATATABLES BOOTSTRAP JS -->
	<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
	<!-- DATATABLES BUTTONS -->
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
	<!-- FANCYAPPS JS -->
	<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
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
