<?php

    define('PLAYER','@');
    define('ENERGIE','+');
    define('TRACE','*');
    define('SORTIE','#');


class Ia{
    var $energie_start;
    var $energie_drop;
    var $distance;
    var $nb_moved = 0;
    var $ia;
    var $sortie;
    var $carte;
    
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
        Ia::var_map();
    }
    
    function var_map(){
        foreach ($this->carte as $ligne){
            foreach ($ligne as $case){
                echo $case;
            }
            echo "\n";   
        }
    }
    
    function radar(){
        
    }
    
    function move(){
        $this->nb_moved++;
        if ($ia['x'] <= $sortie['x']){
            if ($ia['y'] <= $sortie['y']){
                if ($this->nb_moved / 2 == 0){
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
            else{
                if ($this->nb_moved / 2 == 0){
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
        else{
            if ($ia['y'] <= $sortie['y']){
                if ($this->nb_moved / 2 == 0){
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
            else{
                if ($this->nb_moved / 2 == 0){
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