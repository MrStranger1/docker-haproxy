<?php
//Recuperation des donnée
$site_nom_0                  = trim($_POST['site_nom_0']);
$site_nom_serveur_0          = trim($_POST['site_nom_serveur_0']);
$site_adresse_ip_0           = trim($_POST['site_adresse_ip_0']);
$site_nombre_connexion_0     = (int) trim($_POST['site_nombre_connexion_0']);
$data       = array();
$backends   = [];
$frontends  = [];
$sender     = false;

// vérification du nom de domaine
if (empty($site_nom_0) || !preg_match('/^[a-z0-9-_\.]+.(com|fr|net|org)$/i', $site_nom_0)){
    $data['champ'] = 'site_nom_0';
    $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond pas à un nom nom de domaine valide</div>';
}else {
    // vérification du nom du serveur
    if (empty($site_nom_serveur_0) || !preg_match('/^[a-z_-]+$/' , $site_nom_serveur_0)) { // nom_serveur
        $data['champ'] = 'site_nom_serveur_0';
        $data['error'] = '<div class="alert alert-warning">Seul des caractères alphabétiques, tirets et underscores sont autorisés</div>';
    } else {

	// appelle et initialisation de la class
        require 'Haproxy.php';
        $haproxy = new Haproxy('haproxy.local' , $site_nom_0 , $site_nom_serveur_0 , $site_adresse_ip_0 , $site_nombre_connexion_0);

        // verification de l'adresse ip
        //if (empty($site_adresse_ip_0) || !preg_match('/^[0-9]{3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{2,}$/' , $site_adresse_ip_0)) {
        if (empty($site_adresse_ip_0) || $haproxy->checkIP($site_adresse_ip_0) === false) {
            $data['champ'] = 'site_adresse_ip_0';
            $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip valide et un port</div>';
        } else {
            // vérification du nombre maximum de connexion
            if (empty($site_nombre_connexion_0) || !filter_var($site_nombre_connexion_0 , FILTER_VALIDATE_INT)) {
                $data['champ'] = 'site_nombre_connexion_0';
                $data['error'] = '<div class="alert alert-warning">Le nombre maximum de connexion doit être un nombre entier</div>';
            } else {
		$sender = 1;
		//pour si le 1er champs visible est bon
                if (isset($_POST['site_adresse_ip_1'])){
                    if ($haproxy->checkIP($_POST['site_adresse_ip_1'])){
                        $sender += 1;
                        $srvb_1         = $haproxy->createBackupServer($_POST['site_adresse_ip_1'], $_POST['backup_1'] ?? null);
                        $haproxy->addBackupServer1($srvb_1);
		    }else{
			$sender = -1;
                        $data['champ'] = 'site_adresse_ip_1';
                        $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip valide et un port</div>';
                    }
		}

		//pour si le 2em  champs visible est bon
                if(isset($_POST['site_adresse_ip_2'])){
                    if ($haproxy->checkIP($_POST['site_adresse_ip_2'])){
                        $sender += 1;
                        $srvb_2         = $haproxy->createBackupServer($_POST['site_adresse_ip_2'], $_POST['backup_2'] ?? null);
                        $haproxy->addBackupServer2($srvb_2);
		    }else{
			$sender = -1;
                        $data['champ'] = 'site_adresse_ip_2';
                        $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip valide et un port</div>';
                    }
		}
		// Quand tout est ok
                if ($sender >= 1){
                      $data['code'] = 'OK';
                      $haproxy->addAcl();
                      $haproxy->addBackend();
		      $haproxy->merge();
                      $data['error'] = '<div class="alert alert-success">Votre redirection à bien été ajouté dans le fichier et le service démarré</div>';
		      exec('sudo /etc/init.d/haproxy reload');
                }
            }
        }
    }
}
echo json_encode($data);
