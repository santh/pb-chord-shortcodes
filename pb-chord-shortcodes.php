<?php
/**
 * @package           Plectrum banjo Chords Shortcodes
 * @author            Scott Anthony
 * @link              http://www.santhony.com/banjo
 * @wordpress-plugin
 * Plugin Name:       Plectrum Banjo Chord Shortcodes
 * Description:       Creates Plectrum Banjo Chords with the Use of the Simple Shortcode [pb-chord] and a Few Parameters.
 * Version:           1.0.0
 * Author:            Scott Anthony
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require('soundconfig.php');  // points to the sound folder
require_once('shapes.php');
require_once('chord_class.php');
require('build_small_chord.php');
require('build_large_chord.php');


// Version CSS file in a plugin
wp_enqueue_style( 'plugin-styles', plugin_dir_url( __FILE__ ) .  '/css/style.css', array(), filemtime( plugin_dir_path( __FILE__ ) .  '/css/style.css' ) );


add_action( 'wp_enqueue_scripts', 'pb_chord_shortcodes_enqueue_style', 2 );
function pb_chord_shortcodes_enqueue_style(){
    wp_enqueue_style( 'pb_chord_css', plugins_url('css/style.css', __FILE__)); 
}

/*
// Major chord base positions (I, III, and V) based on the lowest chord of the inversion - NOTE: all should have a 0 on at least
// one string
// The last number in the array is the lowest fret number for a "C" chord of the inversion
//
// Extracted to shapes.php
//
$shapes = array('I' => array(0,2,1,3,7), 'III' => array(0,0,1,2,0), 'V' => array(0,1,1,1,4), // assume major if suffix missing
                'majI' => array(0,2,1,3,7), 'majIII' => array(0,0,1,2,0), 'magV' => array(0,1,1,1,4),
                // Minor chord base positions
                'I m' => array(0,1,1,3,7),'III m' => array(0,0,1,1,12), 'V m' => array(0,2,1,2,3),
                // 7th chord base positions
                'I 7' => array(2,1,0,2,8),'III 7' => array(1,1,0,3,11), 'V 7' => array(1,0,2,2,3),'VII 7' => array(2,0,0,3,5),
                // m7th chord base positions
                'I m7' => array(2,0,0,2,8),'III m7' => array(1,1,0,2,11), 'V m7' => array(0,2,1,2,3),'VII m7' => array(3,1,0,4,5),
                // 6th chord base positions
                'I 6' => array(0,2,3,3,7),'III 6' => array(0,2,1,2,0), 'V 6' => array(0,1,1,3,4),'VI 6' => array(2,0,0,2,5),
                // m6th chord base positions
                'I m6' => array(0,1,3,3,7),'III m6' => array(0,2,1,1,0), 'V m6' => array(3,1,0,4,1),'VI m6' => array(3,1,0,3,4),
                'I 9' => array(2,1,0,2,8),'III 9' => array(2,3,1,2,0), 'V 9' => array(1,0,0,2,3),'VII 9' => array(2,2,0,3,5),'IX 9' => array(1,0,2,3,9),
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

*/

global $debug;



/////////////////////////////////////////////////////////////////////////
// 
// Parse name and suffix to calculate the shape based on tables above
// with adjustment for below 0 and above 12th fret  
//
/////////////////////////////////////////////////////////////////////////
//
function get_shape($name, $suffix, $oct)
{
    //echo $name . " " . $suffix . "<br />";
    
    global $keyoffsets;
    global $shapes;
    
    $s = $suffix;
    $octave = $oct;
        
    if(name == 'derived')
    {
        $shape = array($shapes[$s][0], $shapes[$s][1], $shapes[$s][2], $shapes[$s][3]);
        return $shape;
    }
    
    // first split name
    $key = $name[0];
    if(strlen($name) > 1)
    {
        // Only add "b" or "#", ignore anything else (like "add9 +7/b5, etc)
        if($name[1] == "b" || $name[1] == "#")
        {
            $key .= $name[1];
        }
        $pos = stripos($name, "(2)");
        if($pos !== false)
            $octave = 2;
        
    }
    $offset = $keyoffsets[$key]; // Offset of specified key from "C"   
    $offset_from_c = $shapes[$s][4];
    
    $shape = array($shapes[$s][0], $shapes[$s][1], $shapes[$s][2], $shapes[$s][3]);
    
   
    
    // Make adjustments for Key, octave
    
    // Adjust for key
    for($i = 0; $i < 4; $i++)
    {
        $shape[$i] += $offset_from_c; // "C" offset
        $shape[$i] += $offset;
    }

    $min_pos = min($shape);

    // If min position is the 12th fret or above, drop
    // it down a full octave
    if($min_pos > 11)
    {
        for($i = 0; $i < 4; $i++)
        {
            $shape[$i] -= 12;
        }
    }
    else if($min_pos < 0) // If below the nut raise it an octave
    {   
        for($i = 0; $i < 4; $i++)
        {
            $shape[$i] += 12;
        }
    }
   
    // Now, if second octave is specified, bump it up again
    if($octave > 1)
    {
        for($i = 0; $i < 4; $i++)
        {
            $shape[$i] += 12;
        }
    }
    return $shape;  
}

/////////////////////////////////////////////////////////////////////////
// 
// Parse name and suffix to calculate the shape based on tables above
// with no adjustment for below 0 and above 12th fret  
//
/////////////////////////////////////////////////////////////////////////
                  
function get_raw_shape($name, $suffix)
{
    global $keyoffsets;
    global $shapes;
    
    $s = $suffix;
    
    // first split name
    $key = $name[0];
    if(strlen($name) > 1)
    {
        if($name[1] == "b" || $name[1] == "#")
        {
            $key .= $name[1];
        }
    }
    $offset = $keyoffsets[$key]; // Offset of specified key from "C"   
    $offset_from_c = $shapes[$s][4];
    
    $shape = array($shapes[$s][0], $shapes[$s][1], $shapes[$s][2], $shapes[$s][3]);
    
    for($i = 0; $i < 4; $i++)
    {
        $shape[$i] += $offset_from_c; // "C" offset
        $shape[$i] += $offset;
    }
    return $shape;
}

function build_blank($width)
{
    $data = "";
    if($chord->size === 's')
    {
        $data .= '<div id="pb-small-chord-blank-outer" style="width:' . $width . 'px;" ><table style="width:' . $width . 'px;" border="0" ><tr>';                
    }
    else
    {
        $data .= '<div id="pb-chord-blank-outer" style="width:' . $width . 'px;" ><table style="width:' . $cwidth . 'px;" border="0" ><tr>';                
    }
    $data .= '<td >&nbsp;</td>';
    $data .= '</tr></table></div>';
    
    
    return $data;
}



/////////////////////////////////////////////////////////////////////////
// 
// Draw the chord shape diagram
//
// name: the key name of the chord ("C", "Gb", etc.)
// shape: the suffix of the chord ("m7", "7b5", etc.)
// size: normal ('n') or small ('s') default is small
// f: fingering string ('1,3,2,4' etc.)
// wd: width to set outer div. Only used with small chord shapes to provide
//      spacing in line of shapes
//
/////////////////////////////////////////////////////////////////////////
//
function the_chord($atts, $name, $shape, $size='s', $f = "", $wd=19, $o=1, $m=0, $debug=false)
{
    $chord = new Chord();
    $chord->name = $atts['name'];
    $chord->suffix = "";
    $chord->melody = 0;  // offset by +/- 1 or more
    $chord->octave = $o;
    $chord->note = "";
    $chord->shape = "";
    
    
    if(isset($atts['debug']) && $atts['debug'] == true)
    {
        $debug = true;
        echo "debug true <br />";
    }
    else
    {
        $debug = false;
    }
    
    // Suffix could be part of chord name, ie "C7 (III)" or "(2)" could mean second octave
    $pos = stripos($chord->name, "(2)");
    if($pos !== false)
    {
        $chord->octave = 2;
    }
    $test = explode("(", $chord->name);
    
    //var_dump($test);
    
    // Explicit suffix/shape overrides suffix included with name
    if(isset($atts['shape']))
    {   
        $chord->suffix =  $atts['shape']; 
        if(count($test) > 1)
        {
            $chord->name = rtrim($test[0], " ");
        }   
    }
    else
    {
        // If the chord name includes the suffix/shape
        if(count($test) > 1)
        {   
            // Strip following ")"
            $chord->suffix = rtrim($test[1], " )");               
            $chord->name = rtrim($test[0], " ");             

        }
    }
    
    if(isset($atts['size']))
        $chord->size = $atts['size']; // If specified as 's' then small
    else
        $chord->size = 's';
        
    // If the chord is a blank, the number is 1 unless specified by "num"    
    if(isset($atts['num']))
        $num_blanks = $atts['num'];
    else
        $num_blanks = 1;
        
    // If we want to wrap the chord symbals to the next line
    if(isset($atts['wrap']))
        $chord->wrap = $atts['wrap'];
        
    // If we want to wrap the chord symbals to the next line
    if(isset($atts['wd']))
    {
        $chord->wd = $atts['wd'];  
    }
        
    // passed as a string
    if(isset($atts['f']))
    {
        $chord->fingering = $atts['f'];  
    }
    
    // Check if octave set
    if(isset($atts['o']))
    {
        $chord->octave = $atts['o']; 
    }
    
    // Check if the melody note is offset from the normal one designated by the shape
    if(isset($atts['m']))
    {
        $chord->melody = $atts['m'];
    }
        
    // If name is "blank" just return an empty div with an empty table in it
    if($chord->name == 'blank')
    {
        $data = build_blank($chord->wd);
        return $data;     
    }
    
    if(isset($atts['note']))
    {
        $chord->note = $atts['note'];     
        $note = array_map("intval", explode(",", $chord->note));
        
        //show_shape($note, $debug);
        
        for($n=0; $n < 4; $n++)
            $chord->shape[$n] = $note[$n] + 0;
        $chord->fret_pos = max($chord->shape);
        $chord->min_pos = min($chord->shape);
        $chord->max_pos = max($chord->shape);
    }
    else
    {
        $chord->shape = get_shape($chord->name, $chord->suffix, $chord->octave);
        $chord->fret_pos = $chord->note[3];
        $chord->min_pos = min($chord->shape);
        $chord->max_pos = max($chord->shape);
    }
    //$chord->shape = get_shape($chord->name, $chord->suffix, $chord->octave);

    $chord->min_pos = min($chord->shape);
    $chord->max_pos = max($chord->shape);
    
    // If we have a chord shape altered by a positive melody note position,
    // increase the number of frets to display
    if($chord->melody > 0)
        $chord->max_pos += $chord->melody;

    $chord->fret_pos = $chord->shape[3];
    
    //echo "chord->wrap = " . $chord->wrap . " <br />";
    
    $data = "";
    
    // Make sure we show at least 3 frets in the chord shape
    if($chord->max_pos - $chord->min_pos < 3)
    {
        $chord->max_pos ++;
    }
    
    // Try to get a sound file for the chord
    if($chord->size == 'n')
    {
        $chordfolder = "lg_chords";
    }
    else
    {
        $chordfolder = "chords";
    }
    $chord->mp3file = "'" . SOUNDFOLDER. "/". $chordfolder ."/" . $chord->name . "(" . $chord->suffix . ").mp3'";

    //echo "mp3 file = " . $mp3file . "<br />";
    // Draw "normal" sized chord shapes ///////////////////////////////
    if($chord->size == 'n')
    {
        $data = build_large_chord($chord);
        return $data;
    }
    ////////////////////////////////////////////////////////////////////////
    //
    // Small chord shape drawing code
    //
    ///////////////////////////////////////////////////////////////////////
    else // Draw small chord shapes 
    {
        $data = build_small_chord($chord);
        return $data;
    } 
}

/////////////////////////////////////////////////////////////////////////
// 
// Draw either the generic chord shape or one derived from it.
// Derived shapes show the original generic finger positions as 
//   a medium-gray dot and the derived position as a normal black dot.
//
/////////////////////////////////////////////////////////////////////////
//
function render_derive($atts, $suffix, $f = "")
{
    $suffix = $atts['shape'];
    $shape = get_shape("derived", $suffix, 1);
    $f = $atts['f'];

    $data .= '<div id="pb-chord-outer" style="margin-right:5px;"><table border="0" class="pb-chord">';
    $data .= '<tr><td colspan="3" class="pb-chord-name">' . substr($suffix, 1) .'</td></tr>';

    // build the chord
    // $row = fret $s = string
    // Make sure we show at least
    for($row=0; $row<= 6; $row++)
    {
        // If we are at the nut ($row=0) just skip and go to next row
        if($row == 0)
            continue;

        $data .= '<tr>';
        
        // Loop across strings
        for($s=0; $s<4; $s++)
        {
            // Check size of positions[$s]
            $numpos = strlen($shape[$s]);
            $pos = $shape[$s];

            // Initialize "from" and "to" position in case we have 2 dots on the string
            $from = 0;
            $to = 0;
            
            // If there are two dots
            if($numpos == 2)
            {
                // The from position is the first digit
                $from = (int)($pos/10);
                
                // The two position is the second digit
                $to = $pos % 10;   
            }
            else
            {
                // Single digit position 
                $to = $pos % 10;
            }
            //echo "from = " . $from . " to = " . $to . "<br />";
                 
            $class = 'pb-chord-note';                
            $finger = '';
               
            if($to == $row)
            {
                $finger = '<div id="pb-circle">' . " " . '</div>';	
            }
            else if($from == $row)
            {
                $finger = '<div id="pb-empty-circle">' . " " . '</div>';
            }	
            
            if($s == 3)
            {
                $class = "pb-border-none";
                $data .='<td class="' . $class . '"><span>' . $finger . '</span></td>';
            }
            else
            {
                $data .='<td class="' . $class . '"><span>' . $finger . '</span></td>';
            } 
          
            $finger = '';
        }
        $data .= '</tr>';    
    }
    if(isset($atts['f']))
    { 
        $data .= '<tr>';
        for($s = 0; $s<4;$s++)
        {
            $arry = explode(",", $f);
        
            $data .= '<td class="fingering"><span>' . $arry[$s] . '</span></td>';
        }
        $data .= '</tr>';
    }
    $data .= '</table></div>';

    return $data;
}

/////////////////////////////////////////////////////////////////////////
//
// Draw a blank space with text in it
//
/////////////////////////////////////////////////////////////////////////
//
function doblank($atts, $txt, $wd=150)
{
    $txt = $atts['txt'];
    $wd = $atts['wd'];

    
    $data = '<div id="pb-chord-outer" style="margin-right:10px;"><table style="width:'.$wd.'px;"><tr><td> </td></tr>
             <tr><td height="100" class="blankchord">' . $txt . '</td></tr></table></div>';
    return $data;
}

function show_shape($shape, $debug=false)
{
    if($debug == true)
        echo  "(" . $shape[0] . ", " . $shape[1] . ", ". $shape[2] . ", " . $shape[3] . ")<br /> ";
}

function debug($str)
{
    if($debug == true)
        echo $str;
}

function find_in_shapes($shapearray, $row, $string)
{
    $found = -1;
    
    for($s = 0; $s < count($shapearray); $s++)
    {
        for($st = 0; $st < 4; $st++)
        {
            $dot = $shapearray[$s][$st];
            if($st == $string && $dot == $row)
            {
                $found = $s;
                return $found;
            }
        }
    }
    return $found;
}
/////////////////////////////////////////////////////////////////////////
//
// Draw a blank space with text in it
//
/////////////////////////////////////////////////////////////////////////
//
function dofretboard($atts, $name = "", $suffixes="")
{
    // Get the string of suffixes from the parameter list
    $suffixes = $atts['shapes'];
    
    // And the name of the chord
    $name = $atts['name'];
    
    // Get rid of whitespace around commas
    $suffixes = str_replace(", ", ",", $suffixes);
    $suffixes = str_replace(" ,", ",", $suffixes);
    //$suffixes = strtoupper($suffixes);
    
    // First parse the $suffixes string into a series of suffixx
    $suffixarray = explode(",",$suffixes);
    
    $num = count($suffixarray);
    $shapearray = array($num);
    $offset = 0;
    
    for($i = 0; $i < $num; $i++)
    {    
        $suffix = $suffixarray[$i];
        
        $shape = get_shape($name, $suffix, 1);
        $shapearray[$i] = $shape;
    }
    
    // Normal positions of fretmarkers on plectrum banjo
    $fretmarkers = array(1, 3, 5, 7, 10, 12, 15, 17, 19, 22);
    
    $data .= '<div id="pb-chord-outer" style="margin-right:5px;"><table border="0" class="pb-chord">';
    
    // build the chord
    // $row = fret $s = string
    // Make sure we show at least
        
    $data .= '<tr height="14"><td colspan="3" class="pb-chord-name-at-nut">' . $name .'</td></tr>';
   
    // build the chord
    // $row = fret $s = string
    // Make sure we show at least
    for($row=$min_pos; $row <= 22; $row++)
    {
        // If we are at the nut ($row=0) just skip and go to next row
        if($row == 0)
            continue;
    
        $data .= '<tr>';
        
        // Loop across strings
        for($string=0; $string< 4; $string++)
        {        
            // Initialize $dot
            $dot = ' ';
            
            // Initialize class
            $class = 'pb-chord-note';
            
            // Do not want to try to access from $positions beyond the end of the array
            $sh = find_in_shapes($shapearray, $row, $string);
            //echo "shape = " . $sh . " <br />";
            
            if($sh != -1)
            {
                if($sh % 2 == 0)
                {
                    $dot = '<div class="pb-circle-even">' . " " . '</div>';
                }
                else
                {
                    $dot = '<div class="pb-circle-odd">' . " " . '</div>';
                }	
            }		
              
            if($string == 3)
            {
                $class = "pb-border-none";
                $data .='<td class="' . $class . '"><span>' . $dot . '</span></td>';
            }
            else
            {
                $data .='<td class="' . $class . '"><span>' . $dot . '</span></td>';
            }          
            
            if($string == 3)
            {
                if($row == $fret_pos) // Generally, this is the same as the first string
                {
                    $data .= '<td class="pb-fret-marker"><span>' . $row . '</span></td>';
                }
                else
                {
                    if(in_array($row, $fretmarkers))
                        $data .='<td class="pb-empty-fret-marker"><span>' . $row . '</span></td>';
                }
            }
            $finger = '';
        }
        $data .= '</tr>'; 
   
    }
    
    $data .= '</table></div>';

    return $data;


}

add_shortcode( 'pb-blank', 'doblank' );

add_shortcode( 'pb-fretboard', 'dofretboard');
add_shortcode( 'pb-chord', 'the_chord');
add_shortcode( 'pb-derive', 'render_derive' );

?>
