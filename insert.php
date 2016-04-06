<?php
	error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	$f = fopen("numcampi.txt", "r");
	$campi = fgets($f, 150);
	
	fclose($f);
	
	print("	<title>
				Struttura tabella
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
						Struttura tabella
					</font>
				</h1>");
	
	print("<form action = '#' method = 'get'>");
	
	for($c = 0; $c < (int)$campi; $c++)
	{
		print("	<table>
					<tr>
						<td>
							<font face = 'Arial'>
								Nome campo ".(string)($c + 1)."
							</font>
						</td>
						
						<td>
							<input type = 'text' name = 'campo".(string)($c + 1)."' value = '".$_GET["campo".(string)($c + 1)]."'>
						</td>
					</tr>
					
					<tr>
						<td>
							<font face = 'Arial'>
								Tipo campo ".(string)($c + 1)."
							</font>
						</td>
						
						<td>
							<select name = 'tipo".(string)($c + 1)."' style = 'width:173px'>
								<option value = 'int'>
									INT
								</option>
								
								<option value = 'varchar'>
									VARCHAR
								</option>
								
								<option value = 'date'>
									DATE
								</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td>
							<font face = 'Arial'>
								Lunghezza
							</font>
						</td>
						
						<td>
							<input style = 'width:173px' type = 'number' min = '1' max = '65536' name = 'lunghezza".(string)($c + 1)."'>
						</td>
					</tr>
					
					<tr>
						<td>
							<font face = 'Arial'>
								NULL
							</font>
						</td>
						
						<td>
							<input type = 'checkbox' name = 'null".(string)($c + 1)."'>
						</td>
					</tr>
					
					<tr>
						<td>
							<font face = 'Arial'>
								Chiave primaria
							</font>
						</td>
						
						<td>
							<input type = 'checkbox' name = 'primary".(string)($c + 1)."'>
						</td>
					</tr>
					
					<tr>
						<td>
							<font face = 'Arial'>
								Chiave esterna
							</font>
						</td>
						
						<td>
							<input type = 'checkbox' name = 'foreign".(string)($c + 1)."'>
						</td>
					</tr>
					
					<tr>
						<td>
							<font face = 'Arial'>
								Relazione
							</font>
						</td>
						
						<td>
							<select name = 'foreigntab".(string)($c + 1)."' style = 'width: 173px'>");
								
        $file = fopen("database.txt", "r");
        $db = fgets($file, 150);
	    $f = fopen("user.txt", "r");
	    $f2 = fopen("pass.txt", "r");		
				
	    $con = mysqli_connect("localhost", fgets($f, 150), fgets($f2, 150), $db);
		
	    fclose($f);
	    fclose($f2);
	    fclose($file);
		
	    $ris = mysqli_query($con, "SHOW TABLES FROM ".$db);
        
        while($row = mysqli_fetch_array($ris))
        {
			$ris2 = mysqli_query($con, "SHOW KEYS FROM ".$row["Tables_in_".$db]." WHERE Key_name = 'PRIMARY'");
			$row2 = mysqli_fetch_array($ris2);
			
            print("                     <option value = '".$row["Tables_in_".$db]."_".$row2["Column_name"]."'>
                                            '".$row["Tables_in_".$db]."'.'".$row2["Column_name"]."'
                                        </option>");
        }	
    
	    print("		        </select>
						</td>
					</tr>");	
    
	    print("		    </td>
					</tr>
				</table>
				
				<br><br>");
				
	    mysqli_close($con);
	}
	
	print("		<input style = 'width:250px' type = 'submit' name = 'crea' value = 'CREA'>
			</form>");
	
	$campitab = "";
	$campitab2 = "";
	$campitab3 = "";
	
	if(isset($_GET['crea']))
	{	
	    for($c = 0; $c < (int)$campi; $c++)
	    {
	        $primary = false;
	        $foreign = false;
	        
		    if(isset($_GET["campo".(string)($c + 1)])
			    and isset($_GET["tipo".(string)($c + 1)])
			    and isset($_GET["lunghezza".(string)($c + 1)]))
		    {			
			    if(isset($_GET["null".(string)($c + 1)]))
			    {
				    $campitab2 = $campitab2." NULL";				
			    }
			
			    else
			    {
				    $campitab2 = "";
			    }
			    
			    if(isset($_GET["primary".(string)($c + 1)])
			        and !$_GET["foreign".(string)($c + 1)]
					and !$_GET["foreigntab".(string)($c + 1)]
					and !$primary)
			    {
			        $campitab3 = $campitab3.", PRIMARY KEY(".$_GET["campo".(string)($c + 1)].")";
			        $primary = true;	
			        
			        unset($_GET["primary".(string)($c + 1)]);		        
			    }
			
			    if(isset($_GET["primary".(string)($c + 1)])
			        and isset($_GET["foreign".(string)($c + 1)])
					and isset($_GET["foreigntab".(string)($c + 1)])
					and !$primary)
			    {
					$x = 0;
					
					for($i = 0; $i < strlen($_GET["foreigntab".(string)($c + 1)]); $i++)
					{
						$str = $_GET["foreigntab".(string)($c + 1)];
						
						if($str[$i] != "_")
						{
							$tabella = $tabella.$str[$i];
							$x = $i + 1;
						}
						
						else
						{
							break;
						}
					}
					
					for($i = $x + 1; $i <= strlen($_GET["foreigntab".(string)($c + 1)]); $i++)
					{
						$str = $_GET["foreigntab".(string)($c + 1)];
						$chiave = $chiave.$str[$i];						
					}
					
				    $campitab3 = $campitab3.", FOREIGN KEY(".$_GET["campo".(string)($c + 1)].") REFERENCES ".$tabella."(".$chiave.")";				
					$campitab3 = $campitab3.", PRIMARY KEY(".$_GET["campo".(string)($c + 1)].")";
					$primary = true;
					$foreign = true;	
					
					unset($_GET["primary".(string)($c + 1)]);		        				
			    }
			    
			    if(!$_GET["primary".(string)($c + 1)]
			        and isset($_GET["foreign".(string)($c + 1)])
					and isset($_GET["foreigntab".(string)($c + 1)]))
			    {
					$x = 0; 
					
					for($i = 0; $i < strlen($_GET["foreigntab".(string)($c + 1)]); $i++)
					{
						$str = $_GET["foreigntab".(string)($c + 1)];
						
						if($str[$i] != "_")
						{
							$tabella = $tabella.$str[$i];
							$x = $i + 1;
						}
						
						else
						{
							break;
						}
					}
					
					for($i = $x + 1; $i <= strlen($_GET["foreigntab".(string)($c + 1)]); $i++)
					{
						$str = $_GET["foreigntab".(string)($c + 1)];
						$chiave = $chiave.$str[$i];				
					}
					
			        $campitab3 = ", FOREIGN KEY(".$_GET["campo".(string)($c + 1)].") REFERENCES ".$tabella."(".$chiave.")";
			        $foreign = true;			        
			    }
			
				if($primary and !$foreign)
				{
					if(strcmp($_GET["tipo".(string)($c + 1)], "date") == 0)
					{
						$campitab = $campitab." ".$_GET["campo".(string)($c + 1)]." ".$_GET["tipo".(string)($c + 1)].$campitab2.$campitab3;
					} 

					else
					{
						$campitab = $campitab." ".$_GET["campo".(string)($c + 1)]." ".$_GET["tipo".(string)($c + 1)]."(".$_GET["lunghezza".(string)($c + 1)].")".$campitab2.$campitab3;
					}				    	
				}
				
				if(!$primary and $foreign)
				{
					if(strcmp($_GET["tipo".(string)($c + 1)], "date") == 0)
					{
						$campitab = $campitab." ".$_GET["campo".(string)($c + 1)]." ".$_GET["tipo".(string)($c + 1)].$campitab2.$campitab3;	
					}
					
					else
					{
				    	$campitab = $campitab." ".$_GET["campo".(string)($c + 1)]." ".$_GET["tipo".(string)($c + 1)]."(".$_GET["lunghezza".(string)($c + 1)].")".$campitab2.$campitab3;
				    }	
				}
				
				if($primary and $foreign)
				{
					if(strcmp($_GET["tipo".(string)($c + 1)], "date") == 0)
					{
						$campitab = $campitab." ".$_GET["campo".(string)($c + 1)]." ".$_GET["tipo".(string)($c + 1)].$campitab2.$campitab3;
					}
					
					else
					{
				    	$campitab = $campitab." ".$_GET["campo".(string)($c + 1)]." ".$_GET["tipo".(string)($c + 1)]."(".$_GET["lunghezza".(string)($c + 1)].")".$campitab2.$campitab3;	
				    }
				}
				
				if(!$primary and !$foreign)
				{
					if(strcmp($_GET["tipo".(string)($c + 1)], "date") == 0)
					{
						$campitab = $campitab." ".$_GET["campo".(string)($c + 1)]." ".$_GET["tipo".(string)($c + 1)];
					}
					
					else
					{
				    	$campitab = $campitab." ".$_GET["campo".(string)($c + 1)]." ".$_GET["tipo".(string)($c + 1)]."(".$_GET["lunghezza".(string)($c + 1)].")";
				    }
				}
				
				if((int)$campi > 0 and $c < ((int)$campi - 1))
				{
				    $campitab = $campitab.", ";
				}		
		    }
	    }
	
	    $file = fopen("database.txt", "r");
		
		$f = fopen("user.txt", "r");
		$f2 = fopen("pass.txt", "r");		
				
	    $con = mysqli_connect("localhost", fgets($f, 150), fgets($f2, 150), fgets($file, 150));
		
		fclose($f);
		fclose($f2);
	    fclose($file);
	
	    $fp = fopen("nometab.txt", "r");		
	    $ris = mysqli_query($con, "CREATE TABLE ".fgets($fp, 150)." (".$campitab.");");
	    
	    fclose($fp);		
		
        if($ris)
	    {
	        print("	<script>
				        location.href = 'home.php'
			        </script>");
	    }
	    
	    else
	    {
	        die("	<br><br>
	                
	                <font face = 'Arial' color = 'red'>
						".mysqli_error($con)."
					</font>");
	    }
	    
	    mysqli_close($con);
    }
?>
