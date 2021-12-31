Flow
====

Attempt to create a better code analysis engine using an intermediate
representation.

It aims to fundamentally replace [worse-reflection](https://github.com/phpactor/worse-reflection):

- It's Based on an _intermediate representation_ (IR) which augments the underlying AST
  with types.
- Has a mature type engine
- Improved docblock parsing (via. [phpactor-docblock](https://github.com/phpactor/docblock-parser)
- Compeletely abstract the underlying AST from the client.
- Ability to query the IR
- Provide positions of all IR elements to enable refactoring.

Example
-------

```
$class = $flow->locateDefinition(FoobarClass::class);
$methods = $class->findChildNodes(MethodDeclarationElement::class);
$methods->first()->type(); // return type
$methods->first()->name(); // method name

$method = $methodDeclarations->get("doSomething");
$method->classDeclaration();// retun the class declaration

// return all variables in the method scope (i.e. excluding those in anonymous
functions).
$variables = $method
  ->getChild(MethodBody::class)
  ?->getDescendantNodes(VariableElement::class)
  ->filterScope() ?: []; 
```

Principles
----------

- **Performant**: Must be fast for realtime analysis
    - Lazy evaluation of types: Do not eagerly evaluate types in order to
      enable light searching of the IR (e.g. find all property accessors,
      find all method calls).
    - Use generator to yield structural elements
- **Tolerant**: Should not crash
    - Do not constrain type definitions in the code, all types should support
      all operations and override the behavior as necessary.
- **Maintainable**: Easy to fix bugs and extend
    - Strict separation of concern
