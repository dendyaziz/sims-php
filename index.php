<?php
session_start();
include("fc/fc_config.php");
$pages="index.php";
if(empty($_SESSION["iss21"]["authentication"])){$_SESSION["iss21"]["authentication"]="INVALID";}
if($_SESSION["iss21"]["authentication"]=="VALID"){
	header("location: dashboard.php");
}else{

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
    <title>Login :: <?php echo $app_name;?> </title>
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
		#userid{
			-webkit-flex-basis: 90%;
			flex-basis: 90%;
			width: 100%;
			color: #fff;
			font-size: 14px;
			border: none; 
			outline: none;
			padding: .6em .6em;
			-webkit-appearance: none;
			background: transparent;
			transition: 0.5s all;
			-webkit-transition: 0.5s all;
			-moz-transition: 0.5s all;
			-o-transition: 0.5s all;
			-ms-transition: 0.5s all;
			box-sizing: border-box;
		}
		::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
		  color: #999;
		  opacity: 1; /* Firefox */
		}
		
		#btn1{
			width:160px;background-color:#999;			
		}
		#btn1:hover{
			background-color:#333;
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
    <h1 class="error">S.I.M.S</h1>
    <div class="w3layouts-two-grids">
        <div class="mid-class">
			<div class="img-right-side" id="back"> 
				<img src="back.png" width="100%" height="auto"/>
            </div>
            <div class="txt-left-side" ><!--style="background-color:#be1d2c;"-->
			
				<table width="100%">
					<tr>
						<td align="left"><h2 style="color:white;">Login To Your Account<br><p>Enter your details to login.</p></h2></td>
					</tr>
					<tr>
						<td align="left"></td>
					</tr>
				</table>
				
                <form action="fc/fc_login.php" method="post">
					
					<table width="100%">
						<tr>
							<td align="left"><h3 style="color:white;padding-bottom:3px;">USERNAME</h3></td>
						</tr>						
					</table>
                    <div class="form-left-to-w3l" style="background-color:white;color:black;">						
                        <span class="fa fa-user" aria-hidden="true" style="background-color:#999;color:black;"></span>
                        <input type="text" name="userid" id="userid" placeholder="Enter Your Username" required="" style="background-color:white;color:black;">
                        <div class="clear"></div>
                    </div>
					<table width="100%">
						<tr>
							<td align="left"><h3 style="color:white;padding-bottom:3px;">PASSWORD</h3></td>
						</tr>						
					</table>
                    <div class="form-left-to-w3l" style="background-color:white;color:black;padding-bottom:0px;">
                        <span class="fa fa-lock" aria-hidden="true" style="background-color:#999;color:black;"></span>
                        <input type="password" name="password" placeholder="Enter Password" required="" style="background-color:white;color:black;">
                        <div class="clear"></div>
                    </div>
					
					
					
                    <div class="main-two-w3ls">
                        <div class="right-side-forget">
                            <a href="forgot-password.php" class="for" style="font-style:italic;">Forgot Your Password...?</a>
                        </div>
                    </div>
                    <div class="form-left-to-w3l" style="border:none;">
                        <button type="submit" id="btn1">Login </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    <footer class="copyrigh-wthree">
        <!--<p>
            © 2021 Simpanse. All Rights Reserved | Design by
            <a href="https://softkita.monster" target="_blank">Softkita.</a>
        </p>-->
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

<?php
}

?>