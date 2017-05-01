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
        <?= Html::button('Далее', ['class' => 'btn btn-success',
            'onclick' => ' 
                    $.post( "/frontend/web/math-model/lab1-result?number='.'"+$("#number").val(), function ( data ){
                        $("#result").html(data);
                    });
                ']) ?>
    </div>
    
    <p id="result"></p>

<?php Html::endForm(); ?>
    
</div>

