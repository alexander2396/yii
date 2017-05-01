<?php

namespace frontend\controllers;

use Yii;

class MathModelController extends \yii\web\Controller
{
    public function actionLab1()
    {
        if (Yii::$app->request->post()) {
            
            die;
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('lab1');
    }
    
    public function actionLab1Result($number)
    {

        $r0 = (string)$number;
        $r1 = str_shuffle($r0);
        
        for($i = 0; $i < 100; $i++)
        {
            $len = strlen($r0*$r1); 
            $r2 = (int)substr($r0*$r1,ceil($len/4),strlen($r0));
            if(strlen($r2) < strlen($r0)) $r2 = (int)substr($r0*$r1,ceil($len/4),strlen($r0)+1);          
            $res[$i] = (int)$r2;
            $r0 = (int)$r1;
            $r1 = (int)$r2;
        }
        
        print_r($res);die;

    }


}
