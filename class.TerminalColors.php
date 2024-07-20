<?php
// Author: Duayne Bernal, 2023
// Source: https://github.com/DuayneBernal/TerminalColors
class TerminalColors {
  private $foregroundColors;
  private $backgroundColors;

  function __construct() {
    $this->foregroundColors = [
      'LIGHT RED'   => '[1;31m',
      'LIGHT GREEN' => '[1;32m',
      'YELLOW'      => '[1;33m',
      'LIGHT BLUE'  => '[1;34m',
      'MAGENTA'     => '[1;35m',
      'LIGHT CYAN'  => '[1;36m',
      'WHITE'       => '[1;37m',
      'NORMAL'      => '[0m',
      'BLACK'       => '[0;30m',
      'RED'         => '[0;31m',
      'GREEN'       => '[0;32m',
      'BROWN'       => '[0;33m',
      'BLUE'        => '[0;34m',
      'CYAN'        => '[0;36m',
      'BOLD'        => '[1m',
      'UNDERSCORE'  => '[4m',
      'REVERSE'     => '[7m',
    ];

    $this->backgroundColors = [
      'BLACK'   => '[40m',
      'RED'     => '[41m',
      'GREEN'   => '[42m',
      'YELLOW'  => '[43m',
      'BLUE'    => '[44m',
      'MAGENTA' => '[45m',
      'CYAN'    => '[46m',
      'GREY'    => '[47m',
    ];
  }


  private function validColor($color, $colors) {
    $color = strtoupper(str_replace('_', ' ', trim($color)));
    if (isset($colors[$color])) {
      return chr(27) . $colors[$color];
    }

    return '';
  }


  private function validForegroundColor($color) {
    return $this->validColor($color, $this->foregroundColors);
  }


  private function validBackgroundColor($color) {
    return $this->validColor($color, $this->backgroundColors);
  }


  public function foregroundColors() {
    return array_keys($this->foregroundColors);
  }


  public function backgroundColors() {
    return array_keys($this->backgroundColors);
  }


  public function printf($text, $foregroundColor = 'NORMAL', $backgroundColor = '') {
    echo $this->sprintf($text, $foregroundColor, $backgroundColor);
  }


  public function sprintf($text, $foregroundColor = 'NORMAL', $backgroundColor = '') {
    $foreground = '';
    if (is_string($foregroundColor)) {
      $foreground .= $this->validForegroundColor($foregroundColor);
    }

    $background = '';
    if (is_string($backgroundColor)) {
      $background = $this->validBackgroundColor($backgroundColor);
    }

    $formatted = $foreground . $background . $text . chr(27) . '[0m';

    return $formatted;
  }
}
