<?php

class Foo {}

/**
 * @method Foo baz()
 * @method Foo boo()
 */
class Foobar {
    public function __call(string $method, array $args) {
        return new Foo();
    }
}

return get_class((new Foobar())->baz()) === 'Foo';
