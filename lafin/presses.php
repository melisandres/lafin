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
	<?php $page ='presses'; include 'includes/nav.php'; ?>
	<div class="title-area">
		<span class="lafin">
			<strong>Liberal Arts Fictional Institute of Narrative</strong>
		</span>
		<span class="current-page">
			CURRENT PAGE : PRESSES
		</span>
	</div>
	<div class="description">What does fiction bring to mind, if not a good book? What about a fictional book?</div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image" id="c-image">
	<?php $page ='presses'; include 'includes/c-image.php'; ?>
</section>

<section class="c-text">
	<article class="explanation"  id="c-text">
		<?php $page ='presses'; include 'includes/c-text.php'; ?>
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
		We publish distortions&#8211fictions self-aware enough to do their own 
		laundry. Somewhat lifelike, sometimes frail, experiments in being. We
		publish work that doesn't work for a living. We publish those like us, 
		who only exist at certain times, in discrete situations, under a certain
		quality of light. 
	</p>
	<p>
		Would your work fit? How real do you expect to be? 
		Find out <a class="join-us-link" href="javascript:;">more</a>.
	</p>
	</div>
</section>
<!--- End Join us Section -->
<footer>
</footer>

</body>
</html>