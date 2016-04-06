<?php
	error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	print("	<title>
				Login
			</title>
			
			<div align = 'left'>
				<font face = 'Arial'>
					<a href = '../'>
						Esci
					</a>
				</font>
			</div>
			
			<center>
				<h1>
					<font face = 'Arial' color = 'blue'>
						Login
					</font>
				</h1>
				
				<form action = '#' method = 'post'>
					<table>
						<tr>
							<td>
								<font face = 'Arial'>
									Username
								</font>
							</td>
							
							<td>
								<input type = 'text' name = 'user' value = '".$_POST["user"]."'>
							</td>
						</tr>
						
						<tr>
							<td>
								<font face = 'Arial'>
									Password
								</font>
							</td>
							
							<td>
								<input type = 'password' name = 'pass' value = '".$_POST["pass"]."'>
							</td>
						</tr>
					</table>
					
					<br>
					
					<input type = 'submit' name = 'login' value = 'LOGIN'>
					
					<br><br><br>
					   
					<font face = 'Arial'>
						<b>
					    	Copyright (c) 2016 Niccol&ograve Ciavarella. Tutti i diritti riservati.
						</b>
					</font>
				</form>");
				
	if(isset($_POST["login"]))
	{
		$con = mysql_connect("localhost", $_POST["user"], $_POST["pass"]);
		
		if($con)
		{
			session_start();
			
			$_SESSION["user"] = $_POST["user"];
			$_SESSION["pass"] = $_POST["pass"];
			
			$fp = fopen("user.txt", "w");
			
			fwrite($fp, $_POST["user"]);
			
			fclose($fp);
			
			$fp = fopen("pass.txt", "w");
			
			fwrite($fp, $_POST["pass"]);
			
			fclose($fp);
			
			header("location: home.php");
		}
		
		else
		{
			die("	<font face = 'Arial' color = 'red'>
						Cannot log in to the MySQL server
					</font>");
		}
		
		mysqli_close($con);
	}
