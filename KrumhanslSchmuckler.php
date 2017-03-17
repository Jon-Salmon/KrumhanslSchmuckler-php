<?php

class KeyFinder
{
  public $notes;
  private $krumhanslCoeffs;

  function __construct()
  {
    $this->notes = array_fill(0, 12, 0);
    $this->krumhanslCoeffs = array(
      6.35,
      2.23,
      3.48,
      2.33,
      4.38,
      4.09,
      2.52,
      5.19,
      2.39,
      3.66,
      2.29,
      2.88
    );
  }

  private function chordToNum($chord){
    switch ($chord) {
      case 'A':
        return 0;
      case 'A#':
        return 1;
      case 'B':
        return 2;
      case 'C':
        return 3;
      case 'C#':
        return 4;
      case 'D':
        return 5;
      case 'D#':
        return 6;
      case 'E':
        return 7;
      case 'F':
        return 8;
      case 'F#':
        return 9;
      case 'G':
        return 10;
      case 'G#':
        return 11;
      default:
        # not long term solution
        return 0;
    }
  }

  private function numToChord($chord){
    switch ($chord) {
      case 0:
        return 'A';
      case 1:
        return 'Bb';
      case 2:
        return 'B';
      case 3:
        return 'C';
      case 4:
        return 'C#';
      case 5:
        return 'D';
      case 6:
        return 'Eb';
      case 7:
        return 'E';
      case 8:
        return 'F';
      case 9:
        return 'F#';
      case 10:
        return 'G';
      case 11:
        return 'Ab';
      default:
        # not long term solution
        return 0;
    }
  }

  private function loop($int){
    if ($int > 11){
      $int -= 12;
    }
    return $int;
  }

  private function loopArray(&$array){
    array_unshift($array, $array[11]);
    array_pop($array);
  }

  private function correlation($x, $y){

    $mean1=array_sum($x) / 12;
    $mean2=array_sum($y) / 12;

    $a=0;
    $b=0;
    $axb=0;
    $a2=0;
    $b2=0;

    for($i=0;$i<12;$i++)
    {
      $a=$x[$i]-$mean1;
      $b=$y[$i]-$mean2;
      $axb=$axb+($a*$b);
      $a2=$a2+ pow($a,2);
      $b2=$b2+ pow($b,2);
    }

    return $axb / sqrt($a2*$b2);
    }

  public function addChord($chord){
    if (preg_match('/^[A-G]#?/', $chord, $rootL)){
      $root = $this->chordToNum($rootL[0]);
    }
    $minor = False;
    if (preg_match('/^[A-G]#?m/', $chord)){
      $minor = True;
    }
    $this->notes[$root]++;
    if ($minor){
      $this->notes[$this->loop($root+3)]++;
    } else {
      $this->notes[$this->loop($root+4)]++;
    }
    $this->notes[$this->loop($root+7)]++;
  }

  public function getKey(){
    $corrValues = [];
    for ($i = 0; $i < 12; $i++)
    {
      $corrValues[] = $this->correlation($this->krumhanslCoeffs, $this->notes);
      $this->loopArray($this->krumhanslCoeffs);
    }
    $max = array_keys($corrValues, max($corrValues));
    return $this->numToChord($max[0]);
  }


}
?>
