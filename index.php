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
	<div class="description">Lafin is a loosely knit collective of 
		artists and intellectuals investigating narrative, anti-narrative,
		 and narrautonomy. 
		 <br><br><i>*narrautonomy: an autonomous term that redefines 
		itself through singular narrative musings.</i></div>
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
		There are a number of ways to become involved. 
	</p>
	<p>
		At Lafin, we are curious about so many of the things 
		embodied by the words: <i>a crisis in imagination</i>. 
		We believe imagined and unimagined truthes are generally
		humble, speaking to the small and the specific. However,
		we also embrace bold claims, things made of whole cloth, 
		worlds softened with silk, feathers, dry 
		leaves&mdash;spikes, and spider jaws.
	</p>
	<p>	
		We support archival excavations of long forgetten Lafin 
		projects, memories lost in the weeds, events slipped into 
		the unconscious. We welcome follow artists, researchers, and 
		thinkers to join us in rebuilding Lafin's past and future.
	</p>
	<p>
		To join us, administration@lafin.org
	</p>
</section>
<!--- End Join us Section -->
<footer>
</footer>

</body>
</html>