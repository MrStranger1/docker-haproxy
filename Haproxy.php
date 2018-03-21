<?php

/**
 * Class Haproxy
 */
class Haproxy
{
    /**
     * @var string nom du site
     */
    private $site_nom;
    /**
     * @var string nom du serveur
     */
    private $site_nom_serveur;
    /**
     * @var string adresse ip du serveur
     */
    private $site_adresse_ip;
    /**
     * @var int nombre de connexion maximum accepter
     */
    private $site_nombre_connexion;
    /**
     * @var string nom du fichier a remplir
     */
    private $filename;
    /**
     * @var backup active
     */
    private $backup_bool;
    /**
     * @var chaine de caractère du premier serveur de backup
     */
    private $string_srv_backup1;
    /**
     * @var chaine de caractère du deuxieme serveur de backup
     */
    private $string_srv_backup2;

    /**
     * Haproxy constructor.
     * @param string $filename
     * @param string $site_nom
     * @param string $site_nom_serveur
     * @param string $site_adresse_ip
     * @param int $site_nombre_connexion
     */
    public function __construct(string $filename, string $site_nom, string $site_nom_serveur, string $site_adresse_ip, int $site_nombre_connexion)
    {
        $this->filename                 =  $filename;
        $this->site_nom                 = $site_nom;
        $this->site_nom_serveur         = $site_nom_serveur;
        $this->site_adresse_ip          = $site_adresse_ip;
	$this->site_nombre_connexion    = $site_nombre_connexion;
    }


    /**
     * @return bool
     */
    public function addAcl()
    {
        $acl = "\tacl " .$this->createAcl($this->site_nom). '_acl hdr(host) ' .$this->site_nom."\n";
        $acl .= "\tuse_backend ".$this->createAcl($this->site_nom)."_http if ".$this->createAcl($this->site_nom)."_acl\n\n";
        file_put_contents('parts/acl.txt', $acl, FILE_APPEND);
        return true;
    }

    /**
     * @return bool
     */
    public function addBackend()
    {
        file_put_contents('parts/backends.txt', $this->createBackend(), FILE_APPEND);
        return true;
    }

    /**
     * @return string
     */
    private function createBackend()
    {
        $back = "\nbackend ".$this->createAcl($this->site_nom)."_http
        mode http
        option httpchk
        option forwardfor except 127.0.0.1
        http-request add-header X-Forwarded-Proto https if { ssl_fc } \n\t" .
            $this->createServer($this->site_nom_serveur, $this->site_adresse_ip, $this->site_nombre_connexion) ."\n\t";
        if (isset($this->string_srv_backup1) && !empty($this->string_srv_backup1)){
            $back .= $this->string_srv_backup1." backup\n\t";
        }
        if (isset($this->string_srv_backup2) && !empty($this->string_srv_backup2)){
            $back .= $this->string_srv_backup2." backup\n";
        }

        return $back;
    }

    /**
     * @param string $nom_serveur
     * @param string $socket_serveur
     * @param int $maxconn_serveur
     * @return string
     */
    private function createServer(string $nom_serveur, string $socket_serveur, int $maxconn_serveur)
    {
        return "server $nom_serveur $socket_serveur maxconn $maxconn_serveur";
    }

    /**
     * @param string $site_nom_domain
     * @return mixed
     */
    private function createAcl(string $site_nom_domain)
    {
        preg_match('/^[a-z0-9-_]+/', $site_nom_domain, $matches);
        return $matches[0];
    }

    /**
     * @return bool
     */
    public function merge()
    {
        $file_acl = file_get_contents('parts/acl.txt');
        $file_backends = file_get_contents('parts/backends.txt');
        $file_global = file_get_contents('parts/global.txt');
        #file_put_contents('parts/merge.txt', "frontend http-in \n\t\tbind *:80");
        #file_put_contents('parts/merge.txt', $file_global);
        #file_put_contents('parts/merge.txt', $file_acl, FILE_APPEND);
	#file_put_contents('parts/merge.txt', $file_backends, FILE_APPEND);


        file_put_contents('/etc/haproxy/haproxy.cfg', $file_global);
        file_put_contents('/etc/haproxy/haproxy.cfg', $file_acl, FILE_APPEND);
        file_put_contents('/etc/haproxy/haproxy.cfg', $file_backends, FILE_APPEND);

        return true;
    }

    /**
     * @param string $server_ip
     * @param string|null $server_backup
     * @return string
     */
    public function createBackupServer(string $server_ip, string $server_backup = null)
    {
        if (isset($server_backup) && $server_backup == 'on'){
            $server_backup = 'backup';
        }
        $nbr_srv = rand(1, 5);
        return "server " .$this->site_nom_serveur.$nbr_srv." " .$server_ip. " maxconn " .$this->site_nombre_connexion . " " .$server_backup ;
    }

    /**
     * @param string $ip_address
     * @return bool
     */
    public function checkIP(string $ip_address)
    {
	// sinon regex : ^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$
        $socket     = explode(':', $ip_address);
        $ip_array   = explode('.', $socket[0]);
        $ip_return  = array_map(function($ip) use ($ip_array){
		if ($ip < 255 && (int) $ip_array[3] > 0 )
		{ 
			return $ip;
		}else{
			return 'N' ;
  		}
        }, $ip_array);
        // regarde si il y a une erreur
        if (in_array('N', $ip_return) || empty($socket[1]) || (int) $socket[1] <= 10){
            return false;
        }else{
            return  true;
        }
    }

    /**
     * @param string $string_srv_backup1
     * @return string
     */
    public function addBackupServer1(string $string_srv_backup1)
    {
        $this->string_srv_backup1 = $string_srv_backup1;
    }

    /**
     * @param string $string_srv_backup2
     * @return string
     */
    public function addBackupServer2(string $string_srv_backup2)
    {
        $this->string_srv_backup2 = $string_srv_backup2;
    }


}
