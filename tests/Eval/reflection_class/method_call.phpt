<?php

class Foo {}
class Foobar {
    public function baz(): Foo {
        return new Foo();
    }
}

return get_class((new Foobar())->baz()) === 'Foo';

