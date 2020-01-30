<ul class="nav-menu">
		<li class="logo"><a class="<?php if($page =='home'){echo 'active';}?>" href="index.php"><strong>LAFIN</strong></a><li>
		<div class="lafinButtons">
			<!--- Fiction links -->
			<ul class ="dropdown fiction">
				<li><a class="dropbtn fiction <?php if($page =='fiction'){echo 'active';}?>" href="fiction.php">fiction</a><li>
				<ul class="dropdown-content">
					<li>let's not and say we did...</li>
				</ul>
			</ul>
			<!--- End Fiction -->
			<!--- WE -->
			<ul class ="dropdown we">
				<li><a class="dropbtn we <?php if($page =='we'){echo 'active';}?>" href="we.php">we</a></li>
				<ul class="dropdown-content">
					<li><a <?php if($page =='we'){echo 'active';}?> href="we.php">who we are</a></li>
				</ul>
			</ul>
			<!--- End WE  -->
			<!--- DO  -->
			<ul class ="dropdown">
				<li><a class="do dropbtn <?php if($page =='residency'or $page =='academics'or $page =='presses'or $page =='gallery'or $page =='research'){echo 'active';}?>" href="#default">do</a><li>
			<ul class="dropdown-content">
				<li><a class="<?php if($page =='residency'){echo 'active';}?>" href="residency.php">residency</a></li>
				<li><a class="<?php if($page =='academics'){echo 'active';}?>" href="academics.php">academics</a></li>
				<li><a class="<?php if($page =='presses'){echo 'active';}?>" href="presses.php">presses</a></li>
				<li><a class="<?php if($page =='gallery'){echo 'active';}?>" href="gallery.php">gallery</a></li>
				<li><a class="<?php if($page =='research'){echo 'active';}?>" href="research.php">research</a></li>
			</ul>
		</ul>
	</div>
				<!--- End DO  -->
	<li class="hovers">
		<div class="fiction-hover">fiction</div>
		<div class="we-hover">we</div>
		<div class="do-hover">do</div>
	</li>
</ul>

	<?php include 'includes/scripts.php'; ?>

