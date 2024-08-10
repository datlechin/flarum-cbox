<?php

namespace Datlechin\FlarumCbox\Util;

class Color
{
    protected static function hsvToRgb($hue, $saturation, $value): array
    {
        $r = $g = $b = 0;

        $i = floor($hue * 6);
        $f = $hue * 6 - $i;
        $p = $value * (1 - $saturation);
        $q = $value * (1 - $f * $saturation);
        $t = $value * (1 - (1 - $f) * $saturation);

        switch ($i % 6) {
            case 0:
                $r = $value;
                $g = $t;
                $b = $p;
                break;
            case 1:
                $r = $q;
                $g = $value;
                $b = $p;
                break;
            case 2:
                $r = $p;
                $g = $value;
                $b = $t;
                break;
            case 3:
                $r = $p;
                $g = $q;
                $b = $value;
                break;
            case 4:
                $r = $t;
                $g = $p;
                $b = $value;
                break;
            case 5:
                $r = $value;
                $g = $p;
                $b = $q;
                break;
        }

        return [
            'r' => floor($r * 255),
            'g' => floor($g * 255),
            'b' => floor($b * 255)
        ];
    }

    public static function stringToColor(string $string): string
    {
        $num = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            $num += ord($string[$i]);
        }

        $hue = $num % 360;
        $rgb = self::hsvToRgb($hue / 360, 0.3, 0.9);

        return sprintf('%02x%02x%02x', $rgb['r'], $rgb['g'], $rgb['b']);
    }
}
