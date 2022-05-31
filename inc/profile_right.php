<ul class="navbar-nav mr-auto">	
	<li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="fa fa-bars"></i> <?php echo $app_name;?></a></li>
	<li class="nav-item hidden-xs-down" style="padding-left:20px;">
		<h3 class="text-danger"><i class="text-danger fa fa-building"></i> <?php echo $_SESSION["iss21"]["branch"]; ?></h3>
	</li>
</ul>
<ul class="navbar-nav my-lg-0">                        
	<!-- ============================================================== -->
	<!-- Profile -->
	<!-- ============================================================== -->
	<li class="nav-item dropdown u-pro">
		<a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/users/<?php echo $profile_picture;?>" alt="user" class="img-circle" width="32" height="32"> <span class="hidden-md-down"><?php echo $_SESSION["iss21"]["fullname"];?> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
		<div class="dropdown-menu dropdown-menu-right animated flipInY">
			<ul class="dropdown-user">
				<li>
					<div class="dw-user-box">
						<div class="u-img"><img src="assets/images/users/<?php echo $profile_picture;?>" alt="user"></div>
						<div class="u-text">
							<h4><?php echo $_SESSION["iss21"]["fullname"];?></h4>
							<p class="text-muted"><?php echo $_SESSION["iss21"]["email"];?></p><a href="pages-profile.php" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
					</div>
				</li>
				<li role="separator" class="divider"></li>
				<li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
			</ul>
		</div>
	</li>
</ul>