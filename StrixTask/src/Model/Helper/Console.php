<?php

namespace StrixTask\Model\Helper;

final class Console
{

    const COLOR_BLACK = '0;30';
    const COLOR_DARKGRAY = '1;30';
    const COLOR_BLUE = '0;34';
    const COLOR_GREEN = '0;32';
    const COLOR_LIGHTGREEN = '1;32';
    const COLOR_CYAN = '0;36';
    const COLOR_LIGHTCYAN = '1;36';
    const COLOR_RED = '0;31';
    const COLOR_LIGHTRED = '1;31';
    const COLOR_PURPLE = '0;35';
    const COLOR_BROWN = '0;33';
    const COLOR_YELLOW = '1;33';
    const COLOR_LIGHTGRAY = '0;37';
    const COLOR_WHITE = '1;37';

    const COLOR_BACKGROUND_BLACK = 40;
    const COLOR_BACKGROUND_RED = 41;
    const COLOR_BACKGROUND_GREEN = 42;
    const COLOR_BACKGROUND_YELLOW = 43;
    const COLOR_BACKGROUND_BLUE = 44;
    const COLOR_BACKGROUND_MAGNETA = 45;
    const COLOR_BACKGROUND_CYAN = 46;
    const COLOR_BACKGROUND_LIGHTGRAY = 47;

    /** @var array */
    private $params = [];

    private function __clone() {}
    private function __wakeup() {}

    /**
     * @param string $text
     * @param bool   $newLine
     * @param mixed  $color
     * @param mixed  $backgroundColor
     * @return $this
     */
    public function write($text, $newLine = true, $color = null, $backgroundColor = null)
    {
        $string = Runtime::isWindows() ? $text : $this->getColoredText($text, $color);
        echo $string;
        $newLine && $this->newLine();

        return $this;
    }

    /**
     * @return Console
     */
    public function newLine()
    {
        return $this->write(PHP_EOL, false);
    }

    /**
     * @param string $text
     * @param bool   $newLine
     * @return $this
     */
    public function writeInfo($text, $newLine = true)
    {
        return $this->write($text, $newLine, self::COLOR_CYAN);
    }

    /**
     * @param string $text
     * @param bool   $newLine
     * @return $this
     */
    public function writeSuccess($text, $newLine = true)
    {
        return $this->write($text, $newLine, self::COLOR_GREEN);
    }

    /**
     * @param string $text
     * @param bool   $newLine
     * @return $this
     */
    public function writeError($text, $newLine = true)
    {
        return $this->write($text, $newLine, self::COLOR_RED);
    }

    /**
     * @param string $text
     * @param bool   $newLine
     * @return $this
     */
    public function writeWarning($text, $newLine = true)
    {
        return $this->write($text, $newLine, self::COLOR_YELLOW);
    }

    /**
     * @param string $text
     * @param mixed  $color
     * @param mixed  $backgroundColor
     * @return string
     */
    private function getColoredText($text, $color = null, $backgroundColor = null)
    {
        return sprintf("%s[%sm%s%s[0m", chr(27), $color, $text, chr(27));
    }

}
