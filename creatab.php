<?php
	error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	print("	<title>
				Creazione Tabella
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
						Creazione Tabella
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
								<input type = 'text' name = 'nometab' value = '".$_POST['nometab']."'>
							</td>
						</tr>
						
						<tr>
							<td>
								<font face = 'Arial'>
									Numero campi
								</font>
							</td>
							
							<td>
								<input style = 'width:173px' type = 'number' min = '1' max = '65536' name = 'campi'>
							</td>
						</tr>
					</table>
					
					<br><br>
					
					<input style = 'width:250px' type = 'submit' name = 'creatab' value = 'CREA TABELLA'>
				</form>");
				
	if(isset($_POST['nometab'])
		and strcmp(hash('sha256', (get_magic_quotes_gpc() ? stripslashes($_POST['nometab']): $_POST['nometab'])), "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855") != 0)
	{		
		$f = fopen("numcampi.txt", "w");
		
		fwrite($f, $_POST['campi']);
		fclose($f);
		
		$fp = fopen("nometab.txt", "w");
		
		fwrite($fp, $_POST['nometab']);
		fclose($fp);
		
		print("	<script>
					location.href = 'insert.php'
				</script>");
	}
