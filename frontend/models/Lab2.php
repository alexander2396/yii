<?php

namespace frontend\models;

class Lab2 
{

    public function removeSimilar($r)
    {
        foreach($r as $key=>$item)
        {
            if(isset($r[$key+1]) && isset($r[$key]) && $r[$key]['word'] == $r[$key+1]['word'])
            {
                foreach($r as $k=>$i)
                {
                    $r[$key][$k] = $r[$key][$k] + $r[$key+1][$k];
                }  
                unset($r[$key+1]);
                foreach($r as $k=>$i)
                {
                    $r[$k][$key+1] = $r[$k][$key+1] + $r[$k][$key];
                    unset($r[$k][$key]);
                }

                self::removeSimilar($r);
            }
        }
        
        return $r;
    }

}
