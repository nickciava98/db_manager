<?php
    error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
    
	print("	<title>
				Inserisci dati
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
						Inserisci dati
					</font>
				</h1>");
				
	$file = fopen("database.txt", "r");
		
	$f = fopen("user.txt", "r");
	$f2 = fopen("pass.txt", "r");		
				
	$con = mysqli_connect("localhost", fgets($f, 150), fgets($f2, 150), fgets($file, 150));
		
	fclose($f);
	fclose($f2);
	fclose($file);
	
	$fp = fopen("tabnome.txt", "r");
	$nometab = fgets($fp, 150);
	
	$ris = mysqli_query($con, "SELECT * FROM `".$nometab."`");
	
	if(!$ris)
	{
	    die("   <font face = 'Arial' color = 'red'>
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
	
	    $c = count($nomi);
	
	    print("	<form action = '#' method = 'post'>");
	
	    for($i = 0; $i < $c; $i++)
	    {
	        print("	<table>
	        			<tr>
	        				<td>
	        					<font face = 'Arial'>
	        						Nome campo:
	        					</font>
	        				</td>
	        					
	        				<td>");
	
	
		    print("	<font face = 'Arial'>
					    ".$nomi[$i]."
				    </font>");
	
	        print("			</td>
				        <tr>
				
				        <tr>
					        <td>
						        <font face = 'Arial'>
							        Valore
						        </font>
					        </td>
					
					        <td>
						        <input type = 'text' name = 'valore".(string)($i + 1)."' value = '".$_POST['valore'.(string)($i + 1)]."'>
					        </td>
				        </table>
				
				        <br><br>");		
			        
	    }
	
	    print("         <input style = 'width:250px' type = 'submit' name = 'inserisci' value = 'INSERISCI'>");
	        print("	</form>");
	
	    if(isset($_POST['inserisci']))
	    {
	        $ins = "";
	        
	        for($i = 0; $i < $c; $i++)
	        {
	            if($i == 0)
		        {
                    $ins = $ins.$_POST["valore".(string)($i + 1)];				
		        }
		
		        if($i > 0)
		        {
		            $ins = $ins.", ".$_POST["valore".(string)($i + 1)];
		        }
	        }	
		
		    $ris2 = mysqli_query($con, "INSERT INTO `".$nometab."` VALUES(".$ins.")");
		
		    if($ris)
		    {		
		        print("	<script>
					        location.href = 'inserisci.php'
				        </script>");
	        }
	        
	        else
	        {
	            die("	<font face = 'Arial' color = 'red'>
							".mysqli_error($con)."
						</font>");
	        }
				
		    mysqli_close($con);	
	    }
	}
?>
