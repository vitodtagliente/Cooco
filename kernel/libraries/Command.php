<?php

namespace Pure;

abstract class Command {

    public abstract function execute($arguments);

    public abstract function help();

}

?>
