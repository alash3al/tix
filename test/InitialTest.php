<?php

namespace alash3al\tix\Tests;

use PHPUnit\Framework\TestCase;
use alash3al\tix\Tix;

require_once __DIR__ . '/inc/helpers.php';

class InitialTest extends TestCase
{
    public function setup()
    {
        $this->tix = new Tix();
    }

    /**
     * @test
     * @dataProvider timeout_test_provider
     *
     * Verify that Tix can run taking {time} when queue of one
     */
    public function instantiate_and_run_for_n_seconds_single($timeout)
    {
        $start = time();

        $this->tix->push(
            setTimeout(function() {
                $this->exit();
            }, $timeout)
        );

        $this->tix->loop();

        $end = time();
        $diff = $end - $start;

        $this->assertEquals($timeout, $diff);
    }

    /**
     * @test
     * @dataProvider timeout_test_provider
     *
     * Verify that Tix can run taking greater or equal {time} when queue of n
     */
    public function instantiate_and_run_for_n_seconds_multi($timeout)
    {
        $start = time();

        $this->tix->push(
            setTimeout(function() {
                $this->exit();
            }, $timeout)
        );

        for($i=0; $i<rand(1,5); $i++) {
            $this->tix->push(
                setInterval(function() {
                    // just do anything
                    md5("dk@jshd£sjkdhsjdkh6437#846sdksdhdkjshdsjkdh!skd");
                }, rand(1,5))
            );
        }

        $this->tix->loop();

        $end = time();
        $diff = $end - $start;

        $this->assertGreaterThanOrEqual($timeout, $diff);
    }

    public static function timeout_test_provider()
    {
        return [
            [1],[2],[3],[4],[5],
        ];
    }
}
