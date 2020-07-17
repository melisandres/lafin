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
	<?php $page ='research'; include 'includes/nav.php'; ?>
	<div class="title-area">
		<span class="lafin">
			<strong>Liberal Arts Fictional Institute of Narrative</strong>
		</span>
		<span class="current-page">
			CURRENT PAGE : RESEARCH
		</span>
	</div>
	<div class="description">Is fiction a useful tool when it comes to rigourous scientific research? Many would say that it's the enemy of research. We are not amongst the many.</div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image" id="c-image">
	<?php $page ='research'; include 'includes/c-image.php'; ?>
</section>

<section class="c-text">
	<article class="explanation" id="c-text">
		<?php $page ='research'; include 'includes/c-text.php'; ?>
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