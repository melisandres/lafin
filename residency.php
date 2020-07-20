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
	<?php $page ='residency'; include 'includes/nav.php'; ?>
		<div class="title-area">
			<span class="lafin">
				<strong>Liberal Arts Fictional Institute of Narrative</strong>
			</span>
			<span class="current-page">
				CURRENT PAGE : RESIDENCY
			</span>
		</div>
	<div class="description">Various members of our board of directors have taken on the honour of hosting our residency program.</div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image" id="c-image">
	<?php $page ='residency'; include 'includes/c-image.php' ?>
</section>

<section class="c-text">
	<article class="explanation" id="c-text">
		<?php $page ='residency'; include 'includes/c-text.php'; ?>
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
		Over the years, a few Lafin board members have sought to expand their 
		private spaces, adapting them for visiting artists, hosting both short
		and long term residencies.
		
		Unfortunatly, none of our residencies are available at this time. 
		Find out <a class="join-us-link" href="javascript:;">more</a> about 
		how to get involved, when and if a space opens up.
	</p>
	</div>
</section>
<!--- End Join us Section -->
<footer>
</footer>

</body>
</html>