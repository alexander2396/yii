<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "asks".
 *
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property integer $is_done
 */
class Asks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_done'], 'integer'],
            [['question', 'answer'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'is_done' => 'Is Done',
        ];
    }
    
    static public function getDefaultAnswer()
    {
        $var = rand(1,3);
        
        switch($var)
        {
            case 1: return 'Не знаю такого'; break;
            case 2: return 'Да пошел ты'; break;
            case 3: return 'Какой то сепарский вопрос'; break;
        }
    }
}
