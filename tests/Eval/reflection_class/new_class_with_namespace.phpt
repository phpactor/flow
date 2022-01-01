<?php

namespace Barfoo;

class Foobar {
}

$f = new Foobar();

return get_class($f) === 'Barfoo\Foobar';
