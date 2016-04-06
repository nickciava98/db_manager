<?php
	error_reporting(E_ALL ^ (E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED));
	
	print("	<title>
				HOME PAGE
			</title>
			
			<center>
				<h1>
					<font face = 'Arial' color = 'blue'>
						DB Manager
					</font>
				</h1>");
			
	print("	<br><br><br>
	
			<form action = 'creadb.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'creadb' value = 'CREA DATABASE'>
			</form>
			
			<br><br>
			
			<form action = 'selezionadb.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'selezionadb' value = 'SELEZIONA DATABASE ESISTENTE'>
			</form>
			
			<br><br>
			
			<form action = 'creatab.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'creatab' value = 'CREA TABELLA'>
			</form>
			
			<br><br>
			
			<form action = 'inserisci.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'creatab' value = 'INSERISCI DATI IN UNA TABELLA'>
			</form>
			
			<br><br>
			
			<form action = 'visualizzatab.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'seltab' value = 'VISUALIZZA TABELLA ESISTENTE'>
			</form>			
			
			<br><br>
			
			<form action = 'modificatab.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'modificatab' value = 'MODIFICA TABELLA'>
			</form>
			
			<br><br>
			
			<form action = 'eliminatab.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'eliminatab' value = 'ELIMINA TABELLA'>
			</form>
			
			<br><br>
			
			<form action = 'query.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'query' value = 'QUERY SQL'>
			</form>
			
			<br><br>
			
			<form action = 'index.php' method = 'post'>
				<input style = 'width:250px' type = 'submit' name = 'esci' value = 'ESCI'>
			</form>");
?>
