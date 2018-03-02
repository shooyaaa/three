<?php

namespace Shooyaaa\Functions;

class Password {
    public static function hash($password) {
        $hash = \password_has($password, PASSWORD_DEFAULT);

        if (\password_verify($password, $hash)) {
            if (\password_needs_rehash($hash, PASSWORD_DEFAULT)) {

            }
        }

    }
}
