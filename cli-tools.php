<?php
function __autoload($class)
{
    require_once($class.'.php');
}

$console = new ConsoleIO();
//$console->writeln("[\033[1;34mIt works!!!\033[0m]");
$console->writeln("It works!!!");
$console->set_format(ConsoleIO::CYAN, ConsoleIO::BLINK);
$console->writeln("It works!!!");
$console->reset_format();
$console->writeln("It works!!!");
$read = $console->read();
