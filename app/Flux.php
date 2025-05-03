<?php

namespace App;

class Flux
{
    public static function classes($base)
    {
        return new class($base) {
            private $classes = [];

            public function __construct($base) {
                $this->classes[] = $base;
            }

            public function add($class) {
                $this->classes[] = $class;
                return $this;
            }

            public function __toString() {
                return implode(' ', $this->classes);
            }
        };
    }
}
