<?php
	session_start();
	include("fc/fc_config.php");	
	$pages="forgot-password.php";
?>
<!--
Author: Susatyo Widodo Pratama
Author URL: https://softkita.id
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password :: <?php echo $app_name;?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="title.png" rel="shortcut icon" type="image/x-icon" />
    <meta name="keywords" content="Softkita, Software Kita, Web Aplikasi, Web Design, Login Form" />
    <script>
        addEventListener("load", function () { setTimeout(hideURLbar, 0); }, false); function hideURLbar() { window.scrollTo(0, 1); }
    </script>
    <link href="login/css/font-awesome.min.css" rel="stylesheet">
    <link href="login/css/style.css" rel='stylesheet' type='text/css' media="all">
    <link href="//fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
	<style>
		
		#img-right-side{
			padding:0 0 0 0;
		}
		#txt-left-side{
			padding-bottom:0;
			margin-bottom:0;
		}
		::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
		  color: #999;
		  opacity: 1; /* Firefox */
		}
		#back {
			background-image: url('back.png');
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center center;
		}
		.img-right-side{
			padding:0 0 0 0;
		}
		.txt-left-side{
			padding-bottom:0;
			margin-bottom:0;
		}
	</style>
</head>

<body>
    <h1 class="error">LUPA PASSWORD</h1>
    <div class="w3layouts-two-grids">
        <div class="mid-class">
			<div class="img-right-side" id="back">
            <img src="back.png" width="100%" height="auto"/>
			</div>
            <div class="txt-left-side">
                <table width="100%">
					<tr>
						<td align="left"><h2 style="color:white;">Forgot Password?<br><p>Enter your email to get login information.</p></h2></td>
					</tr>
				</table>
                <form action="fc/fc_forgot_password.php" method="post">
					<table width="100%">
						<tr>
							<td align="left"><h3 style="color:white;padding-bottom:3px;">EMAIL</h3></td>
						</tr>						
					</table>
                    <div class="form-left-to-w3l" style="background-color:white;color:black;">
                        <span class="fa fa-envelope-o" aria-hidden="true" style="background-color:#999;color:black;"></span>
                        <input type="email" name="email" placeholder="Email" value="<?php if(!empty($_GET['email'])){echo $_GET['email'];}?>" required="" style="background-color:white;color:black;">
                        <div class="clear"></div>
                    </div>                    
                    
                    <div class="btnn">
                        <button type="submit" style="background-color:#999;">Request Login Information </button>
                    </div>
                </form>                
				<div class="w3layouts_more-buttn">
                    <h3>
                        <a href="index.php" style="color:white;"> <i class="fa fa-arrow-left"></i> Go back to login page
                        </a>
                    </h3>
                </div>

            </div>
            
        </div>
    </div>
    <footer class="copyrigh-wthree">
        <p>
            © 2021 Simpanse. All Rights Reserved | Design by
            <a href="https://softkita.monster" target="_blank">Softkita.</a>
        </p>
    </footer>
	<script src="js/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<?php 
		if(!empty($_SESSION["iss21"]["info"])){
			$info=$_SESSION["iss21"]["info"];
			lapor($info);
			unset($_SESSION["iss21"]["info"]);
		}
	?>
</body>

</html>
