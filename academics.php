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
	<?php $page ='academics'; include 'includes/nav.php'; ?>
	<div class="title-area">
		<span class="lafin">
			<strong>Liberal Arts Fictional Institute of Narrative</strong>
		</span>
		<span class="current-page">
			CURRENT PAGE : ACADEMICS
		</span>
	</div>
	<div class="description">What's the value of a free education?</div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->

<!--- Aside Left-->
<aside class="periods">
	<?php include 'includes/aside-left.php'; ?>
</aside>
<!--- End Aside Left-->

<!--- Centre image -->
<section class="c-image" id="c-image">
	<?php $page ='academics'; include 'includes/c-image.php'; ?>
</section>
<!--- End Centre image -->

<!--- Centre text -->
<section class="c-text">
	<article class="explanation" id="c-text">
		<?php $page ='academics'; include 'includes/c-text.php'; ?>
	</article>
</section>
<!--- End Centre text -->

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
			We are not currently admitting new students, or hiring new faculty. 
			We are, however, always on the lookout for driven and adventurous 
			collaborators. 
		</p>
		<p>
			We believe the journey is tricky; innovation requires the same
			kind of unshakable optimism that makes dangerous ideas seem good. 
			It plunges headlong into the unknown. It relishes in the steadfast
			belief that ours will always be a world of unexplored continents.  
		</p>
		<p>
			At Lafin, the fictional study of narrative expands into every crevice  
			of knowledge, reimagining what it means to engage in study. 
			Find out <a class="join-us-link" href="javascript:;">more</a>.
		</p>
	</div>
</section>
<!--- End Join us Section -->
<footer>
</footer>

</body>
</html>