<!DOCTYPE html>
<head>
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta charset="UTF-8" />
	<title><?php
		if(isset($judul_page)) {
			echo $judul_page;
		}
	?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	<link rel="stylesheet" href="stylesheets/style.css">
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>	
	<script type="text/javascript" src="js/superfish.min.js"></script>	
	<script type="text/javascript" src="js/main.js"></script>	
</head>
<body>
	<div id="page">
	
	<header id="header">
		<div class="container clearfix">
			<div id="logo-wrap">
				<h1 id="logo"><a href="index.php"><img src="images/logospk.png" alt=""></a></h1>
			</div>
			
			<div id="header-content" class="clearfix">
				<nav id="nav">
					<ul class="sf-menu">
						<?php $user_role = get_role(); ?>
						<?php if($user_role == 'admin'): ?>
							<li><a href="show-user.php">User</a>
								<ul>
									<li><a href="show-user.php">List User</a></li>
									<li><a href="add-user.php">Tambah User</a></li>
								</ul>
							</li>						
							<li><a href="show-kriteria.php">Kriteria</a>
								<ul>
									<li><a href="show-kriteria.php">List Kriteria</a></li>
									<li><a href="add-kriteria.php">Tambah Kriteria</a></li>
								</ul>
							</li>
						<?php endif; ?>
						<?php if($user_role == 'admin' || $user_role == 'petugas'): ?>
							<li><a href="show-warga.php">Warga</a>
								<ul>
									<li><a href="show-warga.php">List Warga</a></li>
									<li><a href="add-warga.php">Tambah Warga</a></li>
								</ul>
							</li>
						<?php endif; ?>
						<li><a href="show-ranking.php">Ranking</a>
							<ul>
								<li><a href="show-ranking.php">Topsis</a></li>
							</ul>
						</li>
					</ul>
				</nav>
				
				<div id="header-right">
					<?php if(isset($_SESSION['user_id'])): ?>
						<a href="logout.php" class="button">Log Out</a>
					<?php else: ?>
						<a href="login.php" class="button">Log In</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</header>
	
	<div id="main">