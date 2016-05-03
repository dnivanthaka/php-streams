<?php
class Console{
    private $stderr;
    private $stdout;
    private $stdin;
    private $oformat;

    const BLACK     = "0;30";
    const BLUE      = "0;34";
    const GREEN     = "0;32";
    const CYAN      = "0;36";
    const RED       = "0;31";
    const PURPLE    = "0;35";
    const BROWN     = "0;33";
    const LIGHTGRAY = "0;37";
    const DARKGRAY  = "1;30";
    const LIGHTBLUE = "1;34";
    const LIGHTGREEN = "1;32";
    const LIGHTCYAN  = "1;36";
    const LIGHTRED  = "1;31";
    const LIGHTPURPLE = "1;35";
    const YELLOW    = "1;33";
    const WHITE     = "1;37";

    const USCORE    = '4';
    const BLINK     = '5';
    const INVERSE   = '7';
    const CONCEALED = '8';


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
