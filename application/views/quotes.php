<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style type='text/css'>
/**{
	outline: 1px dotted red;
}*/
	.container{
		vertical-align: top;
		width: 1100px;
		height: 700px;
	}
		.left{
			vertical-align: top;
/*				outline: 1px solid red;*/
			padding-left: 20px;
			display: inline-block;
			width: 425px;
			height: 350px;
		}
			.quotebox{
				margin-top: 10px;
				vertical-align: top;
				outline: 1px solid black;
				width: 380px;
				height: 95px;
			}

		.right{
			margin-left: 400px;
			margin-top: -100px;
			/*outline: 1px solid black;*/
			vertical-align: top;
			display: inline-block;
			width: 500px;				
		}
			.right_top{
				vertical-align: top;
				margin-left: 30px;
				vertical-align: top;
				display: inline-block;
				width: 425px;
			}

			.right_bottom{
				margin-top: 20px;
				outline: 1px solid black;
				margin-left: 30px;
				vertical-align: top;
				display: inline-block;
				width: 425px;
				height: 225px;
			}
</style>
</head>
<body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">Welcome, <?= $user['name'] ?></a>
	    </div>
	    <div>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href='/logout'><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class='container'>
			<div class='left'>
				<h4>Quotable Quotes</h4>
<?php
	foreach($all_quoteinfo as $allquote)
	{
?>				
				<div class='quotebox'>
					

					<p><?= $allquote['quoted_by'] ?>: <?= $allquote['content'] ?></p>
					<p>Posted by <?= $allquote['name'] ?></p>
					<a href="/add_to_favorites/<?= $allquote['id'] ?>"><button type ='button' class='btn btn-primary .btn-md' id='top_button'>Add to My List</button></a>
<?php
	}
?>
				</div>
			</div>
			<div class='right'>
				<div class ='right_top'>
					<h4>Your Favorites</h4>
<?php
	foreach($my_favoritesinfo as $myfavorites)
	{
?>				
				<div class='quotebox'>
					<p><?= $myfavorites['quoted_by'] ?>: <?= $myfavorites['content'] ?></p>
					<p>Posted by <?= $myfavorites['name'] ?></p>
					<a href="/remove_from_favorites/<?= $myfavorites['id'] ?>"><button type ='button' class='btn btn-primary .btn-md' id='top_button'>Remove from My List</button></a>
					</div>
<?php
	}
?>
				
			</div>
				<div class='right_bottom'>
					<h4>Contribute a Quote</h4>
					<form action='/add_quote' method='post'>
							<p>Quoted By: <input type='text' name='quoted_by'></p>
							<p>Message: <textarea name='content'></textarea></p>
							<p></p><input type='submit' class='btn btn-primary .btn-md' value="Submit">
					</form><br>
				</div>
			</div>
	</div>
</body>
</html>