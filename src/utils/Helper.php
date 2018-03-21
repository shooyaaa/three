<?php
namespace Shooyaaa\Three\Utils;

use Symfony\Polyfill\Mbstring\Mbstring;

class Helper {
    public static function abbrevText(string $text, int $length, string $extend) {
        if (Mbstring::mb_strlen($text) > $length) {
            $text = Mbstring::mb_substr($text, 0, $length);
            $text .= $extend;
        }
        return $text;
    }

    public static function mbStrlen(string $text) {
        return Mbstring::mb_strlen($text);
    }

    public static function mbSubstr(string $text, int $start, int $offset) {
        return Mbstring::mb_substr($text, $start, $offset);
    }

    public static function mbStrFragment(string $text, $sectionLen) {
        $pointer = 0;
        $len = static::mbStrlen($text);
        $fragments = [];
        do {
            $temp = "";
            $displayWidth = 0;
            while ($displayWidth < $sectionLen && $pointer <= $len) {
                $char = self::mbSubstr($text, $pointer, 1);
                $pointer ++;
                $bytes = strlen($char);
                if ($bytes > 1) {
                    $displayWidth += 2;
                } else {
                    $displayWidth += 1;
                }
                if ($displayWidth > $sectionLen) {
                    break;
                }
                if ($char == "\n") {
                    $temp .= "\r\n";
                    break;
                }
                $temp .= $char;
            }
            $fragments[] = $temp;
        } while ($pointer <= $len);
        return $fragments;
    }

    public static function numberToChars(int $number) {
        $start = ord('a');
        $end = ord('z');
        $chars = "";
        do {
            $mod = $number % 26;
            $number = floor($number / 26);
            $char = chr($mod + $start);
            $chars = $char . $chars;
        } while ($number > 0);

        return $chars;
    }

    public static function charsToNumber(string $chars) {
        if (!preg_match('/[a-z]{1,}/', $chars)) {
            throw new InvalidArgumentException("invalid chars");
        }
        $start = ord('a');
        $value = 0;
        foreach (range(-1, - strlen($chars)) as $i) {
            $value += (ord($chars[$i]) - $start) * pow(26, (-$i - 1));
        }
        return $value;
    }

    public static function reverseString(string $chars) {
        $low = 0;
        $high= strlen($chars) - 1;
        while ($low < $high) {
            $temp = $chars[$low];
            $chars[$low] = $chars[$high];
            $chars[$high] = $temp;
            $low ++;
            $high --;
        }
        return $chars;
    }

    public static function terminalCols() {
        exec('tput cols', $cols, $code);
        if ($code == 0) {
            return $cols[0];
        }

        return -1;
    }
}
