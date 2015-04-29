<?php

class Ia{
    var $energie_start;
    var $energie_drop;
    var $distance;
    var $ia;
    var $sortie;
    var $carte;
    
    function __construct($argc, $argv){
        if ($argc != 4){
            echo "vous n'avez pas respecté les parametres\n";
            return false;
        }
        var_dump($argv);
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
        Ia::create_map();
       
    }
    
    function create_map(){
        $k = $i = $j = 0;
        $filename = "map.txt";
        $handle = fopen($filename, "r");
        $map = array();
        $content = fread($handle, filesize($filename));
        for ($k =0; isset($content[$k]);$k++){
            if ($content[$k] == "\n"){
                echo $j."if\n";
                $i = 0;
                $j++;
                $map[$i][$j] = $content[$k];
            }
            else{
                $map[$i][$j] = $content[$k];
                echo $i."else\n";
                $i++;
            }
        }
    }
    
    /*function create_map_test(){
        $map[0] = array(' ','@',' ','+',' ',' ','+',' ',' ', ' ');
        $map[1] = array(' ','+',' ',' ','+',' ',' ',' ',' ', ' ');
        $map[2] = array(' ',' ',' ',' ',' ',' ',' ',' ',' ', ' ');
        $map[3] = array(' ','+',' ','+','+',' ',' ',' ','+', ' ');
        $map[4] = array(' ',' ',' ',' ',' ',' ',' ',' ',' ', ' ');
        $map[5] = array(' ','+',' ',' ','+',' ',' ',' ',' ', ' ');
        $map[6] = array(' ',' ',' ',' ',' ',' ',' ',' ',' ', ' ');
        $map[7] = array(' ',' ',' ',' ',' ',' ','+',' ','#', ' ');
        $map[8] = array(' ',' ',' ',' ',' ',' ',' ',' ',' ', ' ');
        $map[9] = array(' ','+',' ',' ','+',' ',' ',' ',' ', ' ');
        $this->carte = $map;
    }*/
}

$ia_test = new Ia($argc, $argv);
var_dump($ia_test);
?>