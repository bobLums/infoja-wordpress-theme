<?php wp_footer();?>
					</div>
				</div>
			</div>
		</div>

		<footer class="footer">
			<div class="container">
				<div class="mx-auto mt-2"><p>footer &copy; <?php echo date("Y");?></p></div>
			</div>
		</footer>
		<script>
			function openNav() {
			  document.getElementById("mySidebar").style.width = "100vw";
			  document.getElementById("main").style.marginLeft = "100vh";
			}

			function closeNav() {
			  document.getElementById("mySidebar").style.width = "0";
			  document.getElementById("main").style.marginLeft= "0";
			}
		</script>
	</body>
</html>