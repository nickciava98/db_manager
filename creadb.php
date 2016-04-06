<?php
    error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	print("	<title>
				Creazione Database
			</title>
			
			<div align = 'left'>
				<font face = 'Arial'>
					<a href = 'home.php'>
						Home Page
					</a>
				</font>
			</div>
			
			<center>
				<h1>
					<font face = 'Arial' color = 'blue'>
						Creazione Database
					</font>
				</h1>
				
				<form action = '#' method = 'post'>
					<table>
						<tr>
							<td>
								<font face = 'Arial'>
									Nome Database
								</font>
							</td>
							
							<td>
								<input type = 'text' name = 'nomedb' value = '".$_POST['nomedb']."'>
							</td>
						</tr>
					</table>
			
					<br><br>
					
					<input style = 'width:250px' type = 'submit' name = 'creadb' value = 'CREA DATABASE'>
				</form>");
				
	if(isset($_POST['nomedb'])
		and strcmp(hash('sha256', (get_magic_quotes_gpc() ? stripslashes($_POST['nomedb']): $_POST['nomedb'])), "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855") != 0)
	{
		session_start();
		
		$con = mysql_connect("localhost", $_SESSION["user"], $_SESSION["pass"]);
		$ris = mysql_query("CREATE DATABASE ".$_POST['nomedb'], $con);
		
		if($ris)
		{
			print("	<script>
					    location.href = 'home.php'
				    </script>");
		}

		else
		{					
			die("	<font face = 'Arial' color = 'red'>
						".mysqli_error($con)."
					</font>");
		}
		
		mysql_close($con);	
	}
