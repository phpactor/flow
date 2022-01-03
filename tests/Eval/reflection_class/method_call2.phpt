<?php

class Foo {}
class Bar {}
class Foobar {
    public function baz(): Foo|Bar {
        return new Bar();
    }
}

return get_class((new Foobar())->baz()) === 'Foo';

