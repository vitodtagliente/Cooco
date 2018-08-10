<?php

namespace Pure;

abstract class ApplicationService
{
	abstract function boot();

	abstract function start();

	abstract function stop();
}

?>