<?php

require_once('chord_class.php');

function build_large_chord($chord)
{
    //var_dump ($chord);
    $data = "";
    if(file_exists($chord->mp3file))
    {
        $data .= "<script type='text/javascript'>function playSound(el, soundfile) {
                    if (el.mp3) {
                        if(el.mp3.paused) el.mp3.play();
                        else el.mp3.pause();
                    } else {
                        el.mp3 = new Audio(soundfile);
                        el.mp3.play();
                    }
                } </script>";
        
        $data .= '<div id="pb-chord-outer" onclick="playSound(this, ' . $chord->mp3file . ');">'; 
    }
    else
    {
        echo "" . file_exists($chord->mp3file);
        $data .= '<div id="pb-chord-outer">'; 
    }

    $data .= '<table border="0" class="pb-chord">';
    $data .= '<tr height="10"><td colspan="3" class="pb-chord-inversion">('. $chord->suffix.')</td></tr>';
    if($chord->min_pos <= 1)  
        $data .= '<tr height="14"><td colspan="3" class="pb-chord-name-at-nut">' . $chord->name .'</td></tr>';
    else
        $data .= '<tr><td colspan="3" class="pb-chord-name">' . $chord->name .'</td></tr>';

        // build the chord
        // $row = fret $s = string
        // Make sure we show at least
    for($row=$chord->min_pos; $row<= $chord->max_pos; $row++)
        {
        // If we are at the nut ($row=0) just skip and go to next row
        if($row == 0)
            continue;
    
        $data .= '<tr>';
        
        // Loop across strings
        for($s=0; $s<4; $s++)
        {        
            $class = 'pb-chord-note';
            if($chord->melody == 0)
            {
                if($chord->shape[$s] == $row)
                    $finger = '<div id="pb-circle">' . " " . '</div>';			
                else
                    $finger = '';
            }
                    
            if($s == 3)
            {
                $data .='<td class="pb-border-none"><span>' . $finger . '</span></td>';
                if($row == $chord->fret_pos)
                {
                    $data .= '<td><div class="pb-fret-marker">' . $chord->fret_pos . '</div></td>';
                }
                $data .= "</td>";
            }
            else
            {
                $data .='<td class="' . $class . '"><span>' . $finger . '</span></td>';
            } 
                
            $finger = '';
        }
        $data .= '</tr>';
            
    }
    if($chord->fingering !== "")
    {
        $data .= '<tr>';
        for($s = 0; $s<4;$s++)
        {
            $arry = explode(",", $chord->fingering);
            
            $data .= '<td class="fingering"><span>' . $arry[$s] . '</span></td>';
        }
        $data .= '</tr>';
    }
    $data .= '</table></div>';
    return $data;
}

?>