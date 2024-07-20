#!/usr/bin/php -q
<?php
// Author: Duayne Bernal, 2023
// Source: https://github.com/DuayneBernal/TerminalColors
require_once("class.TerminalColors.php");
$tc = new TerminalColors();

function printWithColor($tc, $foreground, $background) {
  $tc->printf(sprintf(SPRINTF_FORMAT, "SAMPLE TEXT"), $foreground, $background);
}

$foregroundColors = $tc->foregroundColors();

$backgroundColors = $tc->backgroundColors();

const SPRINTF_FORMAT = "%-14s";

echo PHP_EOL;
echo "Crude example using class.";
echo $tc->printf("Terminal", "NORMAL", "GREEN");
echo $tc->printf("Colors", "NORMAL", "RED");
echo ".php";
echo PHP_EOL;
echo PHP_EOL;

echo sprintf(SPRINTF_FORMAT, "");
echo sprintf(SPRINTF_FORMAT, "No background");
foreach ($backgroundColors as $bg) {
  echo sprintf(SPRINTF_FORMAT, $bg);
}
echo PHP_EOL;

foreach ($foregroundColors as $fg) {
  echo sprintf(SPRINTF_FORMAT, $fg);
  printWithColor($tc, $fg, "");

  foreach ($backgroundColors as $bg) {
    printWithColor($tc, $fg, $bg);
  }

  echo PHP_EOL;
}
echo PHP_EOL;

