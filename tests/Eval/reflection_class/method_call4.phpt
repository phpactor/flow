<?php

class Foo {}
class Bar {}
class Foobar {
    /**
     * @return Foo|Bar
     */
    public function baz()  {
        return new Bar();
    }
}

return get_class((new Foobar())->baz()) === 'Foo';

