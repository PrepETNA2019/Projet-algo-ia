<?php

    define('PLAYER','@');
    define('ENERGIE','+');
    define('TRACE',"\033[01;31m*\033[0m");
    define('SORTIE','#');


class Ia{
    var $energie_start;
    var $energie_drop;
    var $distance;
    var $nb_moved;
    var $ia;
    var $sortie;
    var $carte;
    
    
    /**
     * Constructeur de l'IA avec gestion d'erreur.
     * @param  integer $argc nombre d'argument
     * @param  array $argv tableau d'arguments, ces arguments sont verifier.
     * @return boolean  [[Description]]
     */
    function __construct($argc, $argv){
        if ($argc != 4){
            echo "vous n'avez pas respecté les parametres\n";
            return false;
        }
        if (!is_numeric($argv[1])){
            echo "le 1er argument n'est pas un nombre: fin du programme\n";
            return false;
        }
        $this->energie_start = intval($argv[1]);
        if (!is_numeric($argv[2])){
            echo "le 2eme argument n'est pas un nombre: fin du programme\n";
            return false;
        }
        $this->energie_drop = intval($argv[2]);
        if (!is_readable($argv[3])){
            echo "le 3eme arguments n'est pas un fichier ou n'est pas en lecture: fin du programme\n";
            return false;
        }
        Ia::create_map($argv[3]);
        Ia::check();
        Ia::distance();
        //$valide = true;
        for ($this->nb_moved = 1; $this->energie_start > 0 && Ia::move(); $this->nb_moved++){
            echo "\n\n energie: $this->energie_start | deplacement: $this->nb_moved | distance de depart: $this->distance \n\n";
            Ia::var_map();
            echo "\n\n";
        }
        $this->nb_moved--;
        if ($this->ia['x'] == $this->sortie['x'] && $this->ia['y'] == $this->sortie['y']){
            echo "\nOK\n\n";
        }
        else{
            echo "\nKO\n\n";   
        }
    }
    
    /**
     * donne la distance a parcourir block par block
     * @return boolean return true si il est inferieur a 0.
     */
    function distance(){
        $this->distance= abs($this->ia['x'] - $this->sortie['x']) +
            abs ($this->ia['y'] - $this->sortie['y']);
        return ($this->distance < 0 ? false : true);
    }
    
    /**
     * Initialisateur des parametres de l'ia
     */
    function check(){
        for ($x = 0; isset($this->carte[$x]); $x++){
            for ($y = 0; isset($this->carte[$x][$y]); $y++){
                if ($this->carte[$x][$y] == PLAYER){
                    $this->ia['x'] = $x;
                    $this->ia['y'] = $y;
                }
                if ($this->carte[$x][$y] == SORTIE){
                    $this->sortie['x'] = $x;
                    $this->sortie['y'] = $y;
                }
            }
        }
    }
    
    /**
     * Affiche la carte pour les humains
     */
    function var_map(){
        foreach ($this->carte as $ligne){
            foreach ($ligne as $case){
                echo $case."  ";
            }
            echo "|\n";   
        }
    }
    
    
    /**
     * Gestion des déplacements de l'ia avec une gestion des preferances de parcours si une energie est proche
     * @return boolean return true si une action a ete fait.
     */
    function move(){
        if ($this->ia['x'] == $this->sortie['x'] && $this->ia['y'] == $this->sortie['y'])
            return false;
        $this->energie_start--;
        if ($this->ia['x'] == $this->sortie['x']){
            if ($this->ia['y'] < $this->sortie['y']){
                $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                $this->ia['y']++;
                $this->energie_start = ($this->carte[$this->ia['x']][$this->ia['y']] == ENERGIE ? $this->energie_start + $this->energie_drop : $this->energie_start);
                $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                return true;
            }
            else{
                $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                $this->ia['y']--;
                $this->energie_start = ($this->carte[$this->ia['x']][$this->ia['y']] == ENERGIE ? $this->energie_start + $this->energie_drop : $this->energie_start);
                $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                return true;
            }
        }
        if ($this->ia['y'] == $this->sortie['y']){
            if ($this->ia['x'] < $this->sortie['x']){
                $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                $this->ia['x']++;
                $this->energie_start = ($this->carte[$this->ia['x']][$this->ia['y']] == ENERGIE ? $this->energie_start + $this->energie_drop : $this->energie_start);
                $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                return true;
            }
            else{
                $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                $this->ia['x']--;
                $this->energie_start = ($this->carte[$this->ia['x']][$this->ia['y']] == ENERGIE ? $this->energie_start + $this->energie_drop : $this->energie_start);
                $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                return true;
            }
        }
        
        //cas deplacement lateral vers logitude/latitude
        if ($this->ia['x'] > $this->sortie['x']){
            if ($this->ia['y'] < $this->sortie['y']){
                if ($this->carte[($this->ia['x']) - 1][$this->ia['y']] == ENERGIE ||
                   $this->carte[$this->ia['x']][($this->ia['y']) + 1] == ENERGIE){
                    if ($this->carte[$this->ia['x'] - 1][$this->ia['y']] == ENERGIE){
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['x']--;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    else{
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['y']++;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    $this->energie_start += $this->energie_drop;
                }
                else{
                    if ($this->nb_moved % 2 == 0){
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['x']--;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    else{
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['y']++;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                }
            }
            else{
                if ($this->carte[$this->ia['x'] - 1][$this->ia['y']] == ENERGIE ||
                   $this->carte[$this->ia['x']][$this->ia['y'] - 1] == ENERGIE){
                    if ($this->carte[$this->ia['x'] - 1][$this->ia['y']] == ENERGIE){
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['x']--;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    else{
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['y']--;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    $this->energie_start += $this->energie_drop;
                }
                else{
                    if ($this->nb_moved % 2 == 0){
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['x']--;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    else{
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['y']--;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                }
            }
        }
        else{
            if ($this->ia['y'] > $this->sortie['y']){
                if ($this->carte[$this->ia['x'] + 1][$this->ia['y']] == ENERGIE ||
                   $this->carte[$this->ia['x']][$this->ia['y'] - 1] == ENERGIE){
                    if ($this->carte[$this->ia['x'] + 1][$this->ia['y']] == ENERGIE){
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['x']++;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    else{
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['y']--;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    $this->energie_start += $this->energie_drop;
                }
                else{
                    if ($this->nb_moved % 2 == 0){
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['x']++;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    else{
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['y']--;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                }
            }
            else{
                if ($this->carte[$this->ia['x'] + 1][$this->ia['y']] == ENERGIE ||
                   $this->carte[$this->ia['x']][$this->ia['y'] + 1] == ENERGIE){
                    if ($this->carte[$this->ia['x'] + 1][$this->ia['y']] == ENERGIE){
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['x']++;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    else{
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['y']++;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    $this->energie_start += $this->energie_drop;
                }
                else{
                    if ($this->nb_moved % 2 == 0){
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['x']++;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                    else{
                        $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                        $this->ia['y']++;
                        $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                    }
                }
            }
        }
        return true;
    }
    /**
     * Creation de la carte
     * @param string $filename Nom du fichier text
     */
    function create_map($filename){
        $x = 0;
        $y = 0;
        $handle = fopen($filename, "r");
        $map = array();
        $content = fread($handle, filesize($filename));
        for ($f = 0; isset($content[$f]);$f++){
            if ($content[$f] == "\n"){
                $x++;
                $y = 0;
            }
            else{
                $map[$x][$y] = $content[$f];
                $y++;
            }
        }
        $this->carte = $map;
    }
    
  
}

$ia_test = new Ia($argc, $argv);
//var_dump($ia_test);
?>