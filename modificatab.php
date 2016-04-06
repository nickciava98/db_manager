<?php
	error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	print("	<title>
				Modifica tabella
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
						Modifica tabella
					</font>
				</h1>
				
				<form action = '#' method = 'post'>
					<table>
						<tr>
							<td>
								<font face = 'Arial'>
									Nome tabella
								</font>
							</td>
							
							<td>
								<select name = 'nometab' style = 'width: 173px'>");
								
    $file = fopen("database.txt", "r");
    $db = fgets($file, 150);
	$f = fopen("user.txt", "r");
	$f2 = fopen("pass.txt", "r");		
				
	$con = mysqli_connect("localhost", fgets($f, 150), fgets($f2, 150), $db);
		
	fclose($f);
	fclose($f2);
	fclose($file);
		
	$ris = mysqli_query($con, "SHOW TABLES FROM ".$db);
	$c = 0;
    
    while($row = mysqli_fetch_array($ris))
    {
        print("                     <option value = '".$row["Tables_in_".$db]."'>
                                        ".$row["Tables_in_".$db]."
                                    </option>");
                                    
        $c++;
    }	
    
	print("						</select>
							</td>
						</tr>
					</table>
					
					<br><br>
					
					<input style = 'width:250px' type = 'submit' name = 'modificatab' value = 'MODIFICA TABELLA'>
				</form>");
				
	mysqli_close($con);
				
	if(isset($_POST['nometab']))
	{
		$fp = fopen("modtab.txt", "w");
	
		fwrite($fp, $_POST['nometab']);
		fclose($fp);
		
		print("	<script>
					location.href = 'modify.php'
				</script>");
	}		
?>
