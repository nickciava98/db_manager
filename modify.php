<?php
	error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	print("	<title>
				Modifica
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
						Modifica
					</font>
				</h1>");
				
	$file = fopen("database.txt", "r");
		
	$f = fopen("user.txt", "r");
	$f2 = fopen("pass.txt", "r");		
				
	$con = mysqli_connect("localhost", fgets($f, 150), fgets($f2, 150), fgets($file, 150));
		
	fclose($f);
	fclose($f2);
	fclose($file);
	
	$fp = fopen("modtab.txt", "r");
	$nometab = fgets($fp, 150);
	
	fclose($fp);
	
	$ris = mysqli_query($con, "SELECT * FROM `".$nometab."`");
	$colonne = mysqli_num_fields($ris);
	$nomi = array();
	$c = 0;
	
	while($r = mysqli_fetch_field($ris))
	{
		$nomi[$c] = $r->name;
		$c++;			
	}
	
	print("	<font face = 'Arial'>
				Record tabella ".$nometab."
			</font>
			
			<br><br><br>");
	print("	<table width = '100' cellspacing = '20'>
					<tr>
						<br>");
					
	for($i = 0; $i < $colonne; $i++)
	{
		print("	<td align = 'center'>
					<font face = 'Arial'>
						<b>
							".$nomi[$i]."
						</b>
					</font>
				</td>");
	}
	
	print("	</tr>");
	
	while($row = mysqli_fetch_row($ris)) 
	{ 	
		print("	<tr>
					<td align = 'center'>
						<font face = 'Arial'>
							".implode($row, "	</font>
													</td>
													<td align = 'center'>
														<font face = 'Arial'>")."
														</font>
													</td>
				</tr>");
		print("\n"); 
	}
	
	print("	</table>
			
			<br><br><br>");	
	
	print("	<form action = '#' method = 'post'>
				<table>
					<tr>
						<td>
							<font face = 'Arial'>
								Nome campo da modificare
							</font>
						</td>
						
						<td>
							<select name = 'nomec'>");
						
	for($c = 0; $c < count($nomi); $c++)
	{
	    print("                 <option value = '".$nomi[$c]."'>
	    							".$nomi[$c]."
	    						</option>");
	}
	
	print("					</select>
						</td>
					</tr>
					
					<tr>
						<td>
							<font face = 'Arial'>
								Nuovo valore
							</font>
						</td>
						
						<td>
							<input type = 'text' name = 'nuovo' value = '".$_POST['nuovo']."'>
						</td>
					</tr>
					
					<tr>
						<td>
							<font face = 'Arial'>
								Condizione
							</font>
						</td>
						
						<td>
							<input type = 'text' name = 'cond' value = '".$_POST['cond']."'>
						</td>
					</tr>
				</table>
				
				<br><br>
				
				<input style = 'width:250px' type = 'submit' value = 'MODIFICA'>
			</form>");
			
	if(isset($_POST['nomec']) 
		and isset($_POST['nuovo'])
		and isset($_POST['cond']))
	{
		if(strcmp(hash('sha256', (get_magic_quotes_gpc() ? stripslashes($_POST['cond']): $_POST['cond'])), "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855") != 0)
		{
			$ris2 = mysqli_query($con, "UPDATE `".$nometab."` SET ".$_POST['nomec']." = '".$_POST['nuovo']."' WHERE ".$_POST['cond']);
			
			if(!$ris2)
			{
			    die("	<font face = 'Arial' color = 'red'>
							".mysqli_error($con)."
						</font>");
			}
			
			else
			{
			    header("location: home.php");
			}
		}
		
		else
		{
			$ris2 = mysqli_query($con, "UPDATE ".$nometab." SET ".$_POST['nomec']." = '".$_POST['nuovo']);
			
			if(!$ris2)
			{
			    die("	<font face = 'Arial' color = 'red'>
							".mysqli_error($con)."
						</font>");
			}
			
			else
			{
			    header("location: home.php");
			}
		}
		
		mysqli_close($con);
	}
?>
