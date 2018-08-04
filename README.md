Tix
====
A super simple stupid event-loop written in PHP :D

Why
===
JUST FOR FUN

Usage
=====

```bash
$ chmod +x tix

$ echo "<?php echo 'Hello World';" > hello.tix

$ ./tix hello.tix
> Hello World
```

Examples
========

Examples are located in the `examples` folder of this repo. The `lib`
subdirectory is for supporting code for examples.

The syntax has changed since the original code push.

### Hello Example

This is a simple hello-world example

```bash
$ ./tix examples/hello.tix
```

### Timer Example

This is a setInterval example using code similar to the test suite

```bash
$ ./tix examples/timer.tix
```
