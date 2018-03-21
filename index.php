<html>
	<head>
	    <meta charset="utf-8">
	    <title>Haproxy</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link href="assets/index.css" rel="stylesheet"></link>
		<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
	    <link rel="stylesheet" href="assets/bootstrap.css">
    </head>
<body>

	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
	    <a class="navbar-brand" href=".">Haproxy</a>
	    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto"> 
                     <li class="nav-item active">
                            <a class="nav-link" href="/stats" target="_blank">Voir les stats</a>
                    </li>
                     <li class="nav-item">
                            <a class="nav-link" href="fichier.php">Voir résultat</a>
                    </li>
            </ul>
	    </div>
	</nav>

	<main role="main" class="container col-sm-6">
		 <h1>Ajouter une nouvelle redirection sur Haproxy...</h1><br><br>

		<form method="post" id="form">
			<div id="site_message"></div>

			<div class="form-group" data-send='yes'>
		        <label for="site_nom_0">Nom du domaine de votre site</label>
		        <input type="text" class="form-control" id="site_nom_0" name="site_nom_0" placeholder="calimero.com" data-send='yes'>
		        <span id="help-site_nom_0"></span>
			</div>

			<div class="form-group" data-send='yes'>
                <label for="site_nom_serveur_0">Nom de votre serveur</label>
                <input type="text" class="form-control" id="site_nom_serveur_0" name="site_nom_serveur_0" placeholder="nomserveur">
                <span id="help-site_nom_serveur_0"></span>
            </div>

			<div class="form-group" data-send='yes'>
		            <label for="site_adresse_ip_0">Adresse IP du container et port d'écoute de l'application</label>
		            <input type="text" class="form-control" id="site_adresse_ip_0" name="site_adresse_ip_0" placeholder="172.18.0.1:80" data-send='yes'>
		            <span id="help-site_adresse_ip_0"></span>
			</div>

		  	<div class="form-group add-srv-input" id="add-srv-form-1" style="display: none;">
					<label for="site_adresse_ip_1">Adresse IP du 1<sup>er</sup> container backup et port d'écoute de l'application</label>
			        <input type="text" class="form-control" id="site_adresse_ip_1" name="site_adresse_ip_1" placeholder="172.18.0.2:80">
			        <span id="help-site_adresse_ip_1"></span>
			        <span id="del-srv-1" style="cursor:pointer; font-size:1.2rem; color:red;"> - Supprimer ce serveur</span>

		    </div>

		    <div class="form-group add-srv-input" id="add-srv-form-2" style="display: none;">
					<label for="site_adresse_ip_2">Adresse IP du 2<sup>ème</sup> container backup et port d'écoute de l'application</label>
			        <input type="text" class="form-control" id="site_adresse_ip_2" name="site_adresse_ip_2" placeholder="172.18.0.3:80">
			        <span id="help-site_adresse_ip_2"></span>
			        <span id="del-srv-2" style="cursor:pointer; font-size:1.2rem; color:red;"> - Supprimer ce serveur</span>
		    </div>
		    <span id="add-srv-form" data-target="add-srv-form-1" style="cursor:pointer;color:blue">+ Ajouter un serveur de sauvegarde</span>

		    <div class="form-group" data-send='yes'>
                <label for="site_nombre_connexion_0">Nombre de connexion maximum</label>
                <input type="number" class="form-control" id="site_nombre_connexion_0" name="site_nombre_connexion_0" placeholder="300">
                <span id="help-site_nombre_connexion_0"></span>
            </div>

            <button type="submit" name="send" class="btn btn-primary btn-lg">Créer la redirection</button>
        
		</form>

	</main>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="assets/index.js"></script>  
</body>
</html>
