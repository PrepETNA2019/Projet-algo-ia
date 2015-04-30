<?php

    define('PLAYER','@');
    define('ENERGIE','+');
    define('TRACE','*');
    define('SORTIE','#');


class Ia{
    var $energie_start;
    var $energie_drop;
    var $distance;
    var $nb_moved;
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
        Ia::check();
        Ia::distance();
        $valide = true;
        for ($this->nb_moved = 0; $this->energie_start >= 0 && $valide; $this->nb_moved++){
            echo "\n energie = $this->nb_moved \n\n";
            if (!Ia::move()){
                $valide = false;
                Ia::var_map();
            }
            else {
                Ia::var_map();
            }
            echo "\n\n\n\n";
        }
        
        
    }
    
    function distance(){
        $this->distance= abs($this->ia['x'] - $this->sortie['x'] +
                            $this->ia['y'] - $this->sortie['y']);
        return ($this->distance < 0 ? false : true);
    }
    
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
    
    function var_map(){
        foreach ($this->carte as $ligne){
            foreach ($ligne as $case){
                echo $case."  ";
            }
            echo "|\n";   
        }
    }
    
    function radar(){
        
    }
    
    function move(){
        if ($this->ia['x'] == $this->sortie['x'] && $this->ia['y'] == $this->sortie['y'])
            return false;
        $this->energie_start--;
        if ($this->ia['x'] == $this->sortie['x']){
            if ($this->ia['y'] < $this->sortie['y']){
                echo "\n////////// X ok, y > donc y++\n";
                $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                $this->ia['y']++;
                $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                return true;
            }
            else{
                echo "\n////////// X ok, y > donc y--\n";
                $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                $this->ia['y']--;
                $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                return true;
            }
        }
        if ($this->ia['y'] == $this->sortie['y']){
            if ($this->ia['x'] < $this->sortie['x']){
                echo "\n////////// X ok, y > donc y++\n";
                $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                $this->ia['x']++;
                $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                return true;
            }
            else{
                echo "\n////////// X ok, y > donc y--\n";
                $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                $this->ia['x']--;
                $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                return true;
            }
        }
        
        //cas deplacement lateral vers logitude/latitude
        if ($this->ia['x'] > $this->sortie['x']){
            if ($this->ia['y'] < $this->sortie['y']){
                if ($this->nb_moved % 2 == 0){
                    echo "\n////////// if if if x++\n";
                    $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                    $this->ia['x']--;
                    $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                }
                else{
                    echo "\n////////// if if else y++\n";
                    $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                    $this->ia['y']++;
                    $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                }
            }
            else{
                if ($this->nb_moved % 2 == 0){
                    echo "\n////////// if else if x--\n";
                    $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                    $this->ia['x']--;
                    $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                }
                else{
                    echo "\n////////// if else else y--\n";
                    $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                    $this->ia['y']--;
                    $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                }
            }
        }
        else{
            if ($this->ia['y'] > $this->sortie['y']){
                if ($this->nb_moved % 2 == 0){
                    echo "\n////////// else if if x++\n";
                    $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                    $this->ia['x']++;
                    $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                }
                else{
                    echo "\n//////////  else if else y--\n";
                    $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                    $this->ia['y']--;
                    $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                }
            }
            else{
                if ($this->nb_moved % 2 == 0){
                    echo "\n////////// else else if x--\n";
                    $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                    $this->ia['x']++;
                    $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                }
                else{
                    echo "\n////////// else else else y++\n";
                    $this->carte[$this->ia['x']][$this->ia['y']] = TRACE;
                    $this->ia['y']++;
                    $this->carte[$this->ia['x']][$this->ia['y']] = PLAYER;
                }
            }
        }
        return true;
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