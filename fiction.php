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
	<?php $page ='fiction'; include 'includes/nav.php'; ?>
	<div class="title-area">
		<span class="lafin">
			<strong>Liberal Arts Fictional Institute of Narrative</strong>
		</span>
		<span class="current-page">
			CURRENT PAGE : FICTION
		</span>
	</div>
	<div class="description">Although we are, at most, almost entirely fictional, we operate under the premise that being fictional isn't much of an excuse for anything, other than (maybe) some flakyness when it comes to showing up at a party.</div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image" id="c-image">
	<?php $page ='fiction'; include 'includes/c-image.php'; ?>
</section>

<section class="c-text">
	<article class="explanation" id="c-text">
		<?php $page ='fiction'; include 'includes/c-text.php'; ?>
	</article>
</section>

<!--- Aside Left-->
<aside class="left">

</aside>
<!--- End Aside Left-->

<!--- End Centre page -->

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