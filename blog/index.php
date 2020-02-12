<?php include("../login/runtime.php"); ?>
<?php 
$post_slug = perch_get('s');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Post Title | Blog | Rocket League India</title>

<!-- Favicons Start -->
<link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="../favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="../favicons/manifest.json">
<link rel="mask-icon" href="../favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#122C3E">
<!-- Favicons End -->

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:title" content="Post Title | Blog | Rocket League India">
<meta property="og:image" content="javascript:void(0)">
<meta property="og:description" content="This is a post description.">
<meta property="og:url" content="http://rocketleagueindia.com">
<meta name="description" content="This is a post description.">
<meta name="keywords" content="Rocket League India, RLIndia">

<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/blog.css" rel="stylesheet" type="text/css">
<link href="../css/footer-basic-centered.css" rel="stylesheet" type="text/css">
<link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
</head>

<body>
<!-- HEADER -->
<?php include("../navigation.php"); ?>
<!-- HEADER END -->
<!-- MAIN CONTENT -->
<div class="p-header-image-container p-cover">
	<div class="p-name-container">
		<a href="" rel="bookmark" class="p-name">
			Title of Article
		</a>
	</div>
</div>

<div id="container2" class="container">
    	<div class="inner_container">
			<article class="h-entry">
				
				<p class="meta">
					<span class="p-date-author"><time class="dt-published" datetime="28 Feb, 2017">
					<time>
						28 Feb, 2017
					</time>
						by <span class="p-author h-card">Pawan Kolhe</span></span>
					<span class="p-tag-category">
						<span class="p-tag">Tags: </span><a href="javascript:void(0);" class="p-category">
						Announcement
						</a>
					</span>				
				</p>
				<div>
					<img src="" alt="" />
				</div>
				<div class="description e-content">
					There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
				</div>
			</article>

      </div>
</div>
<!-- MAIN CONTENT END -->
<!-- FOOTER -->
<?php include("../footer.php"); ?>
<!-- FOOTER END -->
</body>
</html>
