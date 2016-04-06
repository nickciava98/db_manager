<?php
	error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	print("	<title>
				Visualizzazione tabella
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
						Visualizzazione tabella
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
					
					<input style = 'width:250px' type = 'submit' name = 'visualizza' value = 'VISUALIZZA'>
				</form>");
				
	mysqli_close($con);
				
	if(isset($_POST['nometab'])
		and strcmp(hash('sha256', (get_magic_quotes_gpc() ? stripslashes($_POST['nometab']): $_POST['nometab'])), "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855") != 0)
	{
		$file = fopen("database.txt", "r");
		
		$f = fopen("user.txt", "r");
		$f2 = fopen("pass.txt", "r");		
				
	    $con = mysqli_connect("localhost", fgets($f, 150), fgets($f2, 150), fgets($file, 150));
		
		fclose($f);
		fclose($f2);
	    fclose($file);
		
		$ris = mysqli_query($con, "SELECT * FROM ".$_POST['nometab']);
		
		if(!$ris)
		{
		    die("	<font face = 'Arial' color = 'red'>
						".mysqli_error($con)."
					</font>");
		}
		
		else
		{		
		    $colonne = mysqli_num_fields($ris);
		    $nomi = array();
		    $c = 0;
		
		    while($r = mysqli_fetch_field($ris))
		    {
			    $nomi[$c] = $r->name;
			    $c++;			
		    }
		
		    print("	<br><br>
				
				    <font face = 'Arial'>
					    Record tabella ".$_POST['nometab']."
				    </font>");
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
		
		    print("	</table>");		
	    }
	    
	    mysqli_close($con);
	}
?>
