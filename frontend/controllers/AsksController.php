<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Asks;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AsksController implements the CRUD actions for Asks model.
 */
class AsksController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Asks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Asks::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Asks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Asks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Asks();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionQuestion($answer = false)
    { 
        $model = new Asks();

        if ($model->load(Yii::$app->request->post())) {
            
            $answer = [];
            $_SESSION['question'] = $model->question;
            $words = explode(' ',$model->question);
            
            foreach ($words as $word)
            {
                if (strlen($word) > 6)
                { 
                    $res = Asks::find()->filterWhere(['like', 'question', $word])->orderBy('count')->one();  
                    if(isset($res->id))
                    {
                        $result[] = $res->answer;
                        $res->count = $res->count + 1;
                        $res->save();
                    }
                }
            }
            if(!isset($result) || empty($result) || $result[0] == false)
            {
                $model->save();
                $answer = Asks::getDefaultAnswer();
            }
            else
            {
                foreach ($result as $item)
                {
                    $answer[] = $item;
                }
                
                $answer = array_unique($answer);
                $answer = implode(' ', $answer);  
            }

            return $this->render('question', [
                'model'  => $model,
                'question'  => $_SESSION['question'],
                'answer' => $answer
            ]);
        } else {
            return $this->render('question', [
                'model'  => $model,
                'question'  => '',
                'answer' => $answer
            ]);
        }
    }

    public function actionAnswer($answer = false)
    {
        
        $model = Asks::find()->where(['answer' => null])->orderBy('RAND()')->one();

        if(!$model)
        {
            Yii::$app->session->setFlash('success', "Активных вопросов нет");
            return $this->redirect('/frontend/web/index.php');
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/frontend/web/index.php');
        } else {
            return $this->render('answer', [
                'model'  => $model
            ]);
        }
    }    
    
    /**
     * Updates an existing Asks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Asks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Asks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Asks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
