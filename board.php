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
	<?php $page ='board'; include 'includes/nav.php'; ?>
	<div class="title-area">
		<span class="lafin">
			<strong>Liberal Arts Fictional Institute of Narrative</strong>
		</span>
		<span class="current-page">
			CURRENT PAGE : OUR BOARD
		</span>
	</div>
	<div class="description">What is it we are anyway? We are a tight knit, loosely woven group. Our Board of Directors, or collective, has seen better and worse, and things you couldn't even imagine.  click <a data-internalid="14" class="archive-button top-desc-link">here</a></div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image">
	<?php $page ='board'; include 'includes/c-image.php'; ?>
</section>

<section class="c-text">
	<article class="explanation" id="c-text">
		<?php $page ='board'; include 'includes/c-text.php'; ?>
	</article>
</section>
<!--- End Centre page -->

<!--- Aside Left-->
<aside class="periods">
	<?php include 'includes/aside-left.php'; ?>
	<br><br>
	<p>   Our current Board of Directors</p>
	<li><a data-internalid="28" class="archive-button bod">Vaughn Knee</a></li>
	<li><a data-internalid="29" class="archive-button bod">Frank Mayfield</a></li>
	<li><a data-internalid="30" class="archive-button bod">Mélisandre Schofield</a></li>
	<li><a data-internalid="31" class="archive-button bod">Stacey Ruggenbaum</a></li>
	<li><a data-internalid="32" class="archive-button bod">Melancholy Starfield</a></li>
	<li><a data-internalid="33" class="archive-button bod">C.A. Swintak</a></li>
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
		Become someone new. Forget about who you are, reality is just a construct
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