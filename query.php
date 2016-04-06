<?php
    error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
    
	print("	<title>
				Query SQL
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
						Query SQL
					</font>
				</h1>
			
				<br>
				
				<font face = 'Arial'>
					Query da eseguire
				</font>
				
				<br><br>
				
				<form action = '#' method = 'post'>				
					<textarea name = 'query' rows = '30' cols = '150'>");
		
    $query = $_POST["query"];
    
    print("  			".$query."
					</textarea>
				
					<br><br>
				
					<input style = 'width:225px' type = 'submit' name = 'esegui' value = 'ESEGUI QUERY'>
				</form>");
	
	if(isset($_POST["esegui"])
	    and isset($_POST['query']) 
		and strcmp(hash('sha256', (get_magic_quotes_gpc() ? stripslashes($_POST['query']): $_POST['query'])), "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855") != 0)
	{
		$file = fopen("database.txt", "r");		
		$f = fopen("user.txt", "r");
		$f2 = fopen("pass.txt", "r");						
	    $con = mysqli_connect("localhost", fgets($f, 150), fgets($f2, 150), fgets($file, 150));
		
		fclose($f);
		fclose($f2);
	    fclose($file);
		
		$ris = mysqli_query($con, $_POST["query"]);
		
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
		
		    if($colonne > 0)
		    {
			    print("	<br><br>
				
					    <font face = 'Arial'>
						    Risultato query
					    </font>");
		    }
		
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
		    }
		
		    print("	</table>");		
	    }
	    
	    mysqli_close($con);
    }
?>
