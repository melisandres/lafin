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
	<?php $page ='gallery'; include 'includes/nav.php'; ?>
	<div class="title-area">
		<span class="lafin">
			<strong>Liberal Arts Fictional Institute of Narrative</strong>
		</span>
		<span class="current-page">
			CURRENT PAGE : GALLERY
		</span>
	</div>
	<div class="description">An online gallery space with a buffalo as a curator.</div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image" id="c-image">
	<?php $page ='gallery'; include 'includes/c-image.php'; ?>
</section>

<section class="c-text">
	<article class="explanation" id="c-text">
		<?php $page ='gallery'; include 'includes/c-text.php'; ?>
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
		Our gallery, not as much of a space as a shifting notion of space.
		Our exhibitions are rare, and hard-to-find. Our artists embrace this 
		inversion of location and object. 
	</p>
	<p>
		Find out <a class="join-us-link" href="javascript:;">more</a>. 
		Our archives are clamshells under tide-flooded sands, they are lockboxes
		reshaped by wild-fires, and rusted manholes in lost alleyways. We 
		collaborate with fishermen, locksmiths, and sanitation workers. Our 
		memories seep into the unlikeliest of places.
	</p>
	</div>
</section>
<!--- End Join us Section -->
<footer>
</footer>

</body>
</html>