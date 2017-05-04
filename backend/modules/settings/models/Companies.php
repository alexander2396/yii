<?php

namespace backend\modules\settings\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property integer $id
 * @property string $title
 * @property string $start_date
 * @property string $created_at
 * @property string $status
 *
 * @property Branches[] $branches
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_at', 'status'], 'required'],
            [['start_date', 'created_at'], 'safe'],
            ['start_date', 'checkDate'],
            [['status'], 'string'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    public function checkDate($attribute,$params)
    {
        $today = date('Y-m-d');
        $selectedDate = date("Y-m-d", strtotime($this->start_date));

        if($selectedDate > $today)
        {
            $this->addError($attribute,'start date must be before today');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'start_date' => 'Start Date',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branches::className(), ['company_id' => 'id']);
    }
}
