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
	<?php $page ='history'; include 'includes/nav.php'; ?>
	<div class="title-area">
		<span class="lafin">
			<strong>Liberal Arts Fictional Institute of Narrative</strong>
		</span>
		<span class="current-page">
			CURRENT PAGE : OUR HISTORY
		</span>
	</div>
	<div class="description">click <a data-internalid="14" class="archive-button top-desc-link">here</a></div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image">
	<?php $page ='history'; include 'includes/c-image.php'; ?>
</section>

<section class="c-text">
	<article class="explanation" id="c-text">
		<?php $page ='history'; include 'includes/c-text.php'; ?>
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
		Over the decades, many artists, intellectuals, and pseudoscientists have collaborated with 
		Lafin to create or investigate aspects of . 
	</p>
	<p>
		Time travel is something we approach with some degree of trepidation&mdash;but if that's 
		the only way to set a meeting, we'll 
		anyway. Think for a moment about who you could never be, but might like
		to try being, just sometimes. Join us. 
		Find out <a class="join-us-link" href="javascript:;">more</a>.
	</p>
	</div>
</section>
<!--- End Join us Section -->
<footer>
</footer>

</body>
</html>