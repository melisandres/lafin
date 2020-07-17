<!DOCTYPE html>
<html lang="en">
<head>
<title>Liberal Arts Fictional Institute of Narrative: HOME</title>
	<?php include 'includes/head.php'; ?>
</head>

<body>
<header> </header>
<!--- Navigation -->
<nav>
	<?php $page ='home'; include 'includes/nav.php'; ?>
	<div class="title-area">
		<span class="lafin">
			<strong>Liberal Arts Fictional Institute of Narrative</strong>
		</span>
		<span class="current-page">
			CURRENT PAGE : HOME
		</span>
		</div>
	<div class="description">The Liberal Arts Fictional Institute of Narrative was named in France, in the early nineteen-tens. Formerly Le Coup de Grace, and before that Le Pavillon Marcault, Lafin marked the end of a period, and with every end, a new beginning.</div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image">	
	<?php $page ='home'; include 'includes/c-image.php'; ?>
</section>

<section class="c-text">
	<article class="explanation">
		<?php $page ='home'; include 'includes/c-text.php'; ?>
	</article>
</section>
<!--- End Centre page -->

<!--- Aside Left-->
<aside class="periods">
	<?php include 'includes/aside-left.php'; ?>
</aside>
<!--- End Aside Left-->

<!--- Join us Section -->
<section class="join-us" onclick="openNav()">
	<div>join us</div>
</section>

<section id="greyed-out">
	<div class="big-square">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
		&times;
	</a>
	<p>
		my my my, what a BIG square!
	</p>
	</div>
</section>
<!--- End Join us Section -->
<footer>
</footer>

</body>
</html>