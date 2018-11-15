<?php
//if( ! defined ('CHORDCLASS'))
require_once ('chord_class.php');

function build_small_chord($chord)
{
    $data = "";
    if(file_exists($chord->mp3file) != false)
    {
        $data .= "<script type='text/javascript'>function playSound(el, soundfile) 
        {
                if (el.mp3) {
                    if(el.mp3.paused) el.mp3.play();
                    else el.mp3.pause();
                } else {
                    el.mp3 = new Audio(soundfile);
                    el.mp3.play();
                }
        } </script>";
    }
    
    $data .= '<div style="width:'.$chord->wd. 'px; margin-left:3px; display:inline-block; float:left; white-space:nowrap;">';  
    if($chord->mp3file !== null)
    {
        $data .= '<div id="pb-small-chord-outer" onclick="playSound(this, ' . $chord->mp3file . ');">';
        $data .= '<table border="0" class="pb-small-chord">';
    }
    else
    {
        $data .= '<div id="pb-small-chord-outer">';
        $data .= '<table border="0" class="pb-small-chord">';
    }
    if($chord->min_pos <= 1)
    {   
        if($chord->name !== "")
            $data .= '<tr height="14"><td colspan="3" class="pb-small-chord-name-at-nut">' . $chord->name .'</td></tr>';             
    }
    else
    {   
        $data .= '<tr><td colspan="3"><div class="pb-small-chord-name">' . $chord->name .'</div></td></tr>';
    }
    ///////////////////////////////////////////////////////
    //
    // Main loop of the output routine.
    // build the chord
    // row = fret
    // s = string
    //
    ////////////////////////////////////////////////////////
    //
    for($row=$chord->min_pos; $row<= $chord->max_pos; $row++)
    {
        if($row == 0)
            continue;
        
        if($chord->max_pos !== 1)
        {
            $data .= '<tr>';
            for($s=0; $s<4; $s++)
            {        
                $class = 'pb-small-chord-note';
    
                if($s < 3)
                {
                    if($chord->shape[$s] == $row)
                    {
                        $finger = '<div id="pb-small-circle">' . " " . '</div>';			
                    }
                    else
                    {
                        $finger = '';
                    }
                }
                else // Melody note show note in gray and the melody note in black
                {
                    $finger = ''; // Initialize to empty
                    
                    if($chord->melody == 0)
                    {
                        if($chord->shape[$s] == $row)
                        {
                            $finger = '<div id="pb-small-circle">' . " " . '</div>';			
                        }
                    }
                    else
                    {   
                        if($chord->shape[$s] == $row)
                        {
                            $finger = '<div id="pb-small-empty-circle">' . " " . '</div>';			
                        }
                        if($chord->shape[$s] + $chord->melody == $row)
                        {
                            $finger = '<div id="pb-small-circle">' . " " . '</div>';			
                        }
                    }
                
                }
                
                if($s == 3)
                {
                    $class = "pb-small-border-none";
        
                    $data .='<td class="' . $class . '"><span>' . $finger . '</span></td>';
                }
                else
                {
                    $data .='<td class="' . $class . '"><span>' . $finger . '</span></td>';
                }   
                if($s == 3)
                {
                    if($row == $chord->fret_pos) // Generally, this is the same as the first string
                    {
                        $data .= '<td class="pb-small-fret-marker"><span>' . $chord->fret_pos . '</span></td>';
                    }
                    else
                    {
                        $data .='<td class="pb-small-empty-fret-marker"></td>';
                    }
                }
                $finger = '';
            }
            $data .= '</tr>';
        }
    }
    $data .= '</table></div>';
    $data .= "</div>";  
    return $data;
}

?>