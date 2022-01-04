<?php

class Foo {}

/**
 * @method baz(): Foo
 */
class Foobar {
    public function __call() {
        return new Foo();
    }
}

return get_class((new Foobar())->baz()) === 'Foo';
