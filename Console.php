<?php
class Console{
    private $stderr;
    private $stdout;
    private $stdin;
    private $oformat;

    public static $BLACK = "0;30";
    public static $BLUE  = "0;34";
    public static $GREEN = "0;32";
    public static $CYAN  = "0;36";
    public static $RED   = "0;31";
    public static $PURPLE = "0;35";
    public static $BROWN = "0;33";
    public static $LIGHTGRAY = "0;37";
    public static $DARKGRAY = "1;30";
    public static $LIGHTBLUE = "1;34";
    public static $LIGHTGREEN = "1;32";
    public static $LIGHTCYAN  = "1;36";
    public static $LIGHTRED = "1;31";
    public static $LIGHTPURPLE = "1;35";
    public static $YELLOW = "1;33";
    public static $WHITE = "1;37";

    public static $USCORE    = '4';
    public static $BLINK     = '5';
    public static $INVERSE   = '7';
    public static $CONCEALED = '8';


    function __construct(){
        $this->stderr = fopen('php://stderr', 'w');

        if($this->stderr === FALSE){
            echo "Error: Cannot open stderr stream\n";
            exit(-1);
        }

        $this->stdout = fopen('php://stdout', 'w');

        if($this->stdout === FALSE){
            echo "Error: Cannot open stdout stream\n";
            exit(-1);
        }
        $this->stdin  = fopen('php://stdin', 'r'); 

        if($this->stdin === FALSE){
            echo "Error: Cannot open stdin stream\n";
            exit(-1);
        }

        $this->oformat = "0";
    }

    function __destruct(){
        if($this->stderr)
            fclose($this->stderr);
        if($this->stdout)
            fclose($this->stdout);
        if($this->stdin)
            fclose($this->stdin);
    }

    public function write($line, $end=false)
    {
        $line = "\033[".$this->oformat."m".$line;
        if($end)
            $line .= "\n";
        return fwrite($this->stdout, $line, strlen($line));
    }
    public function writeln($line)
    {
        $this->write($line, true);
    }

    public function set_format($color, $deco='')
    {
        if($deco != ''){
            $prop = explode(';', $color);
           $color = "${deco};${prop[1]}"; 
        }
        $this->oformat = $color;
    }

    public function reset_format()
    {
        $this->oformat = "0"; 
    }

    public function write_err($line)
    {
        return fwrite($this->stderr, $line, strlen($line));
    }
    public function read()
    {
        return fgets($this->stdin);
    }
}
