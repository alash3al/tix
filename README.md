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

Timer Module?
=============
```php

<?php
class Timer {
    protected $start;

    function __construct() {
        $this->start = time();
    }

    function setInterval($fn, $intval) {
        $self = $this;
        $call = function() use($self, $fn, $intval, &$call) {
            $now = time();
            $diff = ($now - $this->start);
            if ( $diff >= $intval ) {
                $this->start = time();
                $fn();
            }
            tixify($call);
        };
        tixify($call);
    }
};

return new class {
    function setInterval($fn, $intval) {
        return (new Timer())->setInterval($fn, $intval);
    }
};
```

**example.tix:**
```
<?php

    // import "timer.tix" as "timer"
    $this->import("timer.tix", "timer");

    // run a function each 2 seconds
    $this->timer->setInterval(function(){
        echo time() . "\n";
    }, 2);
```

```bash
$ ./tix example.tix
```