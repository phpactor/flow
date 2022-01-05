Flow
====

Attempt to create a better code analysis engine using an intermediate
representation.

It aims to fundamentally replace [worse-reflection](https://github.com/phpactor/worse-reflection). It will:

- Be based on an _intermediate representation_ (IR) which augments the underlying AST
  with types.
- Have a modern type engine
- Feature improved docblock parsing (via. [phpactor-docblock](https://github.com/phpactor/docblock-parser)
- Compeletely abstract the underlying AST from the client.
- Allow the IR to be queried.
- Provide positions of all IR elements to facilitate refactoring.

Example
-------

IR navigation (completion):

```
$element = $flow->parse($source);
$element = $element->findDescendantAtPosition(10);
$element->type(); // e.g. new UnionType(new StringType(), new NullType());
```

IR navigation (diagnostics):

```
$root = $flow->parse($source);
$callsToNonExistingMethods = $root->findDescendantNodes(MethodCallElement::class)->filter(
    fn(MethodCallElement $e) => false === $e->targetExists()
);

foreach ($callsToNonExistingMethods as $nonExistingCall) {
    $nonExistingCall->range()->start()->toInt(); // start byte offset
    $nonExistingCall->range()->end()->toInt();   // end byte offset  
}
```

Reflection (with templating):

```
/**
 * @template T
 */
class Foobar { 
    /** @return T */
    function bar(): mixed { 
        // ... 
    } 

    // ...
}

$class = $flow->reflectClass('Foobar', [
    new StringType('Hello'),
    new ClassType('Foobar'),
]);

$class->methods()->get('bar')->type(); // new StringType('Hello');
```

Principles
----------

- **Performant**: Must be fast for realtime analysis
- **Tolerant**: Should not produce runtime errors from provided code
- **Maintainable**: Easy to fix bugs and extend

Alternative Apporaches
----------------------

- No IR
- Use hash table to store type information
-

```
[
    $n1 => StringType("foo"),
    $n2 => ClassType("Bar"),
]
```

```
$type = $interpreter->interpret($node);
```
