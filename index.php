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
	<div class="name"><strong>Liberal Arts Fictional Institute of Narrative</strong><br><br><br>CURRENT PAGE : HOME</div>
	<?php $page ='home'; include 'includes/nav.php'; ?>
	<div class="description">The Liberal Arts Fictional Institute of Narrative was named in France, in the early nineteen-tens. It was the end of a period, and with every end, a new beginning.</div>
</nav>
<!--- End Navigation -->

<!--- Centre page -->
<section class="c-image" id="c-image">	
	<?php $page ='home'; include 'includes/c-image.php'; ?>
</section>

<section class="c-text">
	<article class="explanation" id="c-text">
		<?php $page ='home'; include 'includes/c-text.php'; ?>
	</article>
</section>
<!--- End Centre page -->

<!--- Aside Left-->
<aside class="periods">
	<?php include 'includes/aside-left.php'; ?>
</aside>
<!--- End Aside Left-->


<!--- Aside Right-->
<aside class="projects">
	<?php include 'includes/aside-right.php'; ?>
</aside>
<!--- End Aside Right -->

<footer>
<!--- Join us Section -->
	<a href="#default" class=nav-link>join us</a>
<!--- End Join us Section -->
</footer>

</body>
</html>