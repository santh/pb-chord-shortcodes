<?php

class Chord 
{
    public $name = "";
    public $suffix = "";
    public $shape = "";
    public $fingering = "";
    public $size = "s";
    public $melody = 0;     // Sets melody note +/- number from shape description
    public $note = 0;       // Display a single note if not positive number
    public $octave = 1;
    public $wd = 30;
    public $mp3file = "";
    public $min_pos = 0;
    public $max_pos = 0;
    public $fret_pos = 0;
    public $wrap = 'n';
}
?>