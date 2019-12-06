<!doctype html>
<html lang="en">
<head>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Apace</title>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'  />

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">

	<link href="<?=Apace::getDataUrl('css/minified');?>layout.css" rel="stylesheet"/>
	<link href="<?=Apace::getDataUrl('css/lib');?>apacegrid.css" rel="stylesheet"/>

</head>

<body>

	<h1>Welcome to Apace MVC!</h1>
	<?=$data['content']?>
		
	<script type="text/javascript" src="<?=Apace::getDataUrl('js/minified');?>app.js"></script>