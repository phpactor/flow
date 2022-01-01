<?php

class Foobar {
    public function baz(): Return
}

return get_class((new Foobar())->baz()) === 'Return';

