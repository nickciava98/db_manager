<?php
	error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	print("	<title>
				Selezione Database
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
						Selezione Database
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
								<select name = 'namedb' style = 'width: 173px'>");
								
    $f = fopen("user.txt", "r");
	$f2 = fopen("pass.txt", "r");		
				
	$con = mysql_connect("localhost", fgets($f, 150), fgets($f2, 150));
		
	fclose($f);
	fclose($f2);
	fclose($file);
		
	$ris = mysql_query("SHOW DATABASES", $con);
        
    while($row = mysql_fetch_array($ris))
    {
        print("                     <option value = '".$row["Database"]."'>
                                        ".$row["Database"]."
                                    </option>");
    }	
    
	print("		                </select>
							</td>
						</tr>
					</table>
					
					<br><br>
					
					<input style = 'width:250px' type = 'submit' name = 'selezionadb' value = 'SELEZIONA DATABASE'>
				</form>");
				
	mysql_close($con);
				
	if(isset($_POST['namedb'])
		and strcmp(hash('sha256', (get_magic_quotes_gpc() ? stripslashes($_POST['namedb']): $_POST['namedb'])), "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855") != 0)
	{
		$file = fopen("database.txt", "w");
		
		fwrite($file, $_POST["namedb"]);
		
		$f = fopen("user.txt", "r");
		$f2 = fopen("pass.txt", "r");		
				
	    $con = mysqli_connect("localhost", fgets($f, 150), fgets($f2, 150), $_POST["namedb"]);
		
		fclose($f);
		fclose($f2);
	    fclose($file);
		
		if(!$con)
		{
			die("	<br><br>
			
					<font face = 'Arial' color = 'red'>
						".mysqli_error($con)."
					</font>");
		}
		
		else
		{
			$f = fopen("database.txt", "w");
			
			fwrite($f, $_POST['namedb']);
			fclose($f);
		
			print("	<script>
						location.href = 'home.php'
					</script>");
		}
		
		mysqli_close($con);
	}
