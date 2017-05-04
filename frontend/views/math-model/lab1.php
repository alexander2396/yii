<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
?>
<h1>Построение датчиков псевдослучайных чисел с заданным законом распределения</h1>

<div class="asks-form" style="margin-top:40px;">

    <?= Html::beginForm('', 'post'); ?>

        <div class="form-group">
            <?= Html::label('Введите число', 'number', ['class' => 'control-label']) ?>
            <?= Html::input('number','','', ['id' => 'number','class' => 'form-control',]); ?>
        </div>

        <div class="form-group">
            <?= Html::button('Просчитать', ['class' => 'btn btn-success',
                'onclick' => ' 
                        $.post( "/frontend/web/math-model/lab1-result?number='.'"+$("#number").val(), function ( data ){
                            $("#result").html(data);
                        });
                    ']) ?>
        </div>

        <div id="result"></div>

    <?php Html::endForm(); ?>
    
</div>

