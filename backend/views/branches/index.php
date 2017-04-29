<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BranchesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branches-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Create Branches', ['value' => Url::to('/backend/web/branches/create'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>
    
    <?php
        Modal::begin([
                    'header' => '<h4>Branches</h4>',
                    'id'     => 'modal',
                    'size'   => 'modal-lg',
                ]);
        
        echo "<div id='modalContent'></div>";
        
        Modal::end();
    ?>
    
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'  => function($model){
            if($model->status == 'inactive')
            {
                return ['class' => 'danger'];
            }
            else
            {
                return ['class' => 'success'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'company_id',
                'value'     => 'company.title'
            ],
            'title',
            'created_at',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    
</div>
