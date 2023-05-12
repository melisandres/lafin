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
	<div class="description">Our history extends past the projects we've crafted and the programs we've spearheaded. It drifts through our community, the ways we've connected, the people we've <a data-internalid="40" class="archive-button top-desc-link">become.</a></div>
	<script>
		var myLinks = document.getElementsByClassName("top-desc-link");
		if (defaulted){
			myLinks[0].classList.add("p-active");
		}

	</script>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image" id="c-image">
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
		Over the decades, many artists, intellectuals, 
		pseudoscientists, and narrautonomists have collaborated
		with Lafin to further the mission. 
	</p>
	<p>
		In putting together our history, moments stick to other 
		moments. A gluey substance transfers to everything our 
		archivists' touch, as they engage in the strange task of 
		pulling moments apart, and setting time-lines against
		the natural flow of time, to dry them before their 
		pressing.
	</p>
	<p> 
		At Lafin history is pressing. It is the past and the 
		future all happening at once, discovery and invention
		are one. Join us. 
		Find out <a class="join-us-link" href="javascript:;">more</a>.
	</p>
	</div>
</section>
<!--- End Join us Section -->
<footer>
</footer>

</body>
</html>