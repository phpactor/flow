Flow analysis use casees:

- Indexing:
  - Determine references to a type
- Completion:
  - Discover context for completion
- Refactoring:
  - Find method calls, properties, etc

Non use cases:

- Finding references to a type in source code: Types can be structural
  elements (e.g. class properties, class names). Flow analysis cannot help
  with this.

  Although: if the property is _used_ then flow analysis may be able to
  infertype information for it. But that "information" may well be in a
  completely different source file.

```
<?php

$ir = $interpret->interpret($code);
$ir->findMethodCalls(Class::class, 'foobar');

$node = $ir->nodeAtOffset(1234);
$node->getRange()->start(); // new LineCol(1, 1);
if ($node instanceof TypedNode) {
    echo $node->getType(); // e.g. new StringLiteralType("foobar"), new StringType(), etc;
}
if ($node instanceof MethodCall) {
    echo $node->getClassType(); // new ClassType("Foobar")
    echo $node->getReturnType();
}
if ($node instanceof UnhandledNode) {
    echo $node->getNodeClass();
}
