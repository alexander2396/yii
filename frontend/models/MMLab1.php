<?php

namespace frontend\models;

class MMLab1 
{

    //количество генерируемых чисел
    static private $iterationCount = 100;
    
    //метод серединных произведений
    public function middleMultiplication($number)
    {
        $r0 = (string)$number;
        $r1 = str_shuffle($r0);

        for($i = 0; $i < self::$iterationCount; $i++)
        {
            $len = strlen($r0*$r1); 
            $r2 = (int)substr(number_format($r0*$r1, 2, '.', ''),ceil($len/4),strlen($r0));
            if(strlen($r2) < strlen($r0)) $r2 = (int)substr(number_format($r0*$r1, 2, '.', ''),ceil($len/4),strlen($r0)+1);
            if(strlen($r2) < strlen($r0)) $r2 = (int)substr(number_format($r0*$r1, 2, '.', ''),ceil($len/4),strlen($r0)+2);
            if(strlen($r2) < strlen($r0)) $r2 = (int)substr(number_format($r0*$r1, 2, '.', ''),ceil($len/4),strlen($r0)+3);
            $res[$i] = (int)$r2;
            $r0 = (int)$r1;
            $r1 = (int)$r2;
        }
        
        return $res;
    }
    
    //метод перемешивания
    public function mixing($number)
    {
        $r0 = (string)$number;
        $len = strlen($r0);
        
        for($i = 0; $i < self::$iterationCount; $i++)
        {
            $r1 = substr($r0,$len/4) . substr($r0, 0, $len/4);
            $r2 = substr($r0,-$len/4) . substr($r0,0,-$len/4);
           
            if(strlen($r1 + $r2) > $len)
                $r0 = substr($r1 + $r2,0,-1);
            else 
                $r0 = $r1 + $r2;
            
            if(strlen($r0) < $len)
                $r0 = $r0 . '1';
            
            $res[$i] = (int)$r0;

        }
        
        return $res;
    }
    
    //представление для массива
    public function arrayView($rowset)
    {
        $view = '<div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Массив значений
                    <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
        foreach ($rowset as $item)
        {
            $view .= '<li><a>' . $item . '</a></li>';
        }
        $view .= '</ul></div>';
        
        return $view;
    }

    //представление для характеристик ГСЧ
    public function calculateRNG($rowset)
    {
        //мат. ожидание
        $mo = 0;
        foreach ($rowset as $item)
        {
            $mo += $item;
        }
        $mo = $mo/count($rowset);
        
        //дисперсия
        $dp = 0;
        foreach ($rowset as $item)
        {
            $dp += ($item - $mo) * ($item - $mo);
        }
   
        $dp = $dp/count($rowset);

        //среднеквадратическое отклонение
        $so = sqrt($dp);
        
        //частота попадания
        $frequency = 0;
        foreach ($rowset as $item)
        {
            if($item > $mo - $so && $item < $mo + $so)
                $frequency++;
        }
        $frequency = $frequency * 100 / count($rowset);
        
        $view = '<br>Математическое ожидание: ' . (int)$mo;
        $view .= '<br>Дисперсия: ' . number_format($dp, 2, '.', '');
        $view .= '<br>Среднеквадратическое отклонение: ' . (int)$so;
        $view .= '<br>Частота попадания: ' . $frequency;
        
        return $view;
    }
}
