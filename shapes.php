<?php

// Major chord base positions (I, III, and V) based on the lowest chord of the inversion - NOTE: all should have a 0 on at least
// one string
// The last number in the array is the lowest fret number for a "C" chord of the inversion
$shapes = array('I' => array(0,2,1,3,7), 'III' => array(0,0,1,2,0), 'V' => array(0,1,1,1,4), // assume major if suffix missing
                'majI' => array(0,2,1,3,7), 'majIII' => array(0,0,1,2,0), 'magV' => array(0,1,1,1,4),
                // Minor chord base positions
                'I m' => array(0,1,1,3,7),'III m' => array(0,0,1,1,12), 'V m' => array(0,2,1,2,3),
                // 7th chord base positions
                'I 7' => array(2,1,0,2,8),'III 7' => array(1,1,0,3,11), 'V 7' => array(1,0,2,2,3),'VII 7' => array(2,0,0,3,5),
                // m7th chord base positions
                'I m7' => array(2,0,0,2,8),'III m7' => array(1,1,0,2,11), 'V m7' => array(0,2,1,2,3),'VII m7' => array(3,1,0,4,4),
                // 6th chord base positions
                'I 6' => array(0,2,3,3,7),'III 6' => array(0,2,1,2,0), 'V 6' => array(0,1,1,3,4),'VI 6' => array(2,0,0,2,5),
                // m6th chord base positions
                'I m6' => array(0,1,3,3,7),'III m6' => array(0,2,1,1,0), 'V m6' => array(3,1,0,4,1),'VI m6' => array(3,1,0,3,4),
                'I 9' => array(2,1,0,2,8),'III 9' => array(2,3,1,2,0), 'V 9' => array(1,0,0,2,3),'VII 9' => array(2,2,0,3,5),'IX 9' => array(1,0,2,3,9),
                'I 13' => array(1,0,1,1,9), 'III 13' => array(0,2,1,2,0), 'VI 13' => array(1,0,2,4,3), 'VII 13' => array(1,0,2,4,3),
                
                // 7+5 chord base positions
                'I 7+5' => array(2,1,1,2,8),'III 7+5' => array(1,2,0,3,11), 'V 7+5' => array(1,0,2,3,3),'VII 7+5' => array(3,0,0,3,5),
                // 7b5 chord base positions
                'I 7b5' => array(3,2,0,3,7),'III 7b5' => array(1,0,0,3,11), 'V 7b5' => array(1,0,2,1,3),'VII 7b5' => array(1,0,0,3,5),
               
                'dim' => array(2,1,0,3,7),
                'aug' => array(0,1,1,2,8),
                'altI 7' => array(1,0,2,1,9),'altIII 7' => array(0,3,1,2,0), 'altV 7' => array(1,0,2,2,3),'altVII 7' => array(2,1,0,0,8),
                'alt V' => array(0,0,5,5,0), 'alt2 V' => array(0,5,5,5,0),
                
                // Chord derivations below this line
                'dI' => array(2,4,3,5), 'dI m' => array(2,43,3,5), 'dI 7' => array(25,4,3,5), 'dalt I 7' => array(25,4,36,5),
                'dIII'=> array(2,2,3,4), 'dIII m'=> array(2,2,3,43), 'dIII 7' => array(2,2,31,4), 'dalt III 7' => array(2,25,3,4),
                'dV' => array(2,3,3,3), 'dV m' => array(21,3,32,3), 'dV 7' => array(2,31,3,3), 
                'dVII 7' => array(4,2,2,5), 
                'dI m7' => array(2,43,2,5),   'dVII m7' => array(4,2,21,5),
                    );

$keyoffsets = array('C' => 0,
                    'C#' => 1,
                    'Db' => 1,
                    'D' => 2,
                    'D#' => 3,
                    'Eb' => 3,
                    'E' => 4,
                    'F' => 5,
                    'F#' => 6,
                    'Gb' => 6,
                    'G' => 7,
                    'G#' => 8,
                    'Ab' => 8,
                    'A' => 9,
                    'A#' => 10,
                    'Bb' => 10,
                    'B' => 11,
                    );


?>