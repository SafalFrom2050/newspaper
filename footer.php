        <footer>
			&copy; Northampton News 2017
			<?php
				if(User::isLoggedIn()){
					echo '<a href="account/logout.php">Logout</a>';
				}
			?>
            
		</footer>

	</body>
</html>
