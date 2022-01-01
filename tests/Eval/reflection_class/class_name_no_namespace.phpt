<?php

class Foobar {
}

$f = new Foobar();

return get_class($f) === 'Foobar';
