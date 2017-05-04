<?php

namespace frontend\controllers;

use Yii;
use frontend\models\MMLab1;
use yii\helpers\Json;

class MathModelController extends \yii\web\Controller
{
    public function actionLab1()
    {
        return $this->render('lab1');
    }
    
    public function actionLab1Result($number)
    {

        $model = new MMLab1(); 
        
        //метод серединных произведений
        $rowset = $model->middleMultiplication($number);
        
        $view = '<h3>Метод серединных произведений</h3>';
        
        //представление для массива
        $view .= $model->arrayView($rowset);
        
        //представление для характеристик
        $view .= $model->calculateRNG($rowset);
        
        //----------------------------------------------
        
        //метод перемешивания
        $rowset = $model->mixing($number);
        
        $view .= '<h3>Метод перемешивания</h3>';
        
        //представление для массива
        $view .= $model->arrayView($rowset);
        
        //представление для характеристик
        $view .= $model->calculateRNG($rowset);
        
        echo $view;

    }


}
