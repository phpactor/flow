<?php

class Foo {}
class Foobar {
    public function baz(): Foo|Bar {
        return new Foo();
    }
}

return get_class((new Foobar())->baz()) === 'Foo';

