<?php
require_once('./imagecreate.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	
    $f=$_REQUEST['file'];
    $src = 'uploaded/profile_pic/'.$f;
	$out='output/'.$f;
	list($width, $height, $type, $attr) = getimagesize($src);

    $x=$_POST['x'];
    $y=$_POST['y'];
    $w =$_POST['w']; 
	$h = $_POST['h'];
	

	$obj = new imageLib($src);
	$obj -> cropImage($width-$x, $height-$y, 'br');
    $obj -> saveImage($out, 100);
    $obj = new imageLib($out);
    $obj -> cropImage($w, $h, 'tl');
    $obj -> saveImage($out, 100);

	

	header('Location:'.$out);
	

	exit;
}

// If not a POST request, display page below:

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<script src="./scripts/image_cropping/js/jquery.min.js"></script>
		<script src="./scripts/image_cropping/js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="./scripts/image_cropping/css/jquery.Jcrop.css" type="text/css" />
		
		<script language="Javascript">

			$(function(){

				$('#cropbox').Jcrop({
					aspectRatio: 1,
					onSelect: updateCoords
				});

			});

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

		</script>

	</head>

	<body>
     <center>
	<div id="outer">
	<div class="jcExample">
	<div class="article">

		<h1></h1>

		
		<?php
           $f=$_REQUEST['file'];
           $src = 'uploaded/profile_pic/'.$f;
           echo '<img src='.$src.' id="cropbox" />';
		?>
		

		
		<form action="crop.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden"  name="file" value=<?php echo $f; ?> />
			<input type="submit" value="Crop Image" />
		</form>

		<p>
			
		</p>

		


	</div>
	</div>
	</div>
</center>
	</body>

</html>
