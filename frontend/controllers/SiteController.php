<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays Lab 2 page.
     *
     * @return mixed
     */
    public function actionLab2()
    {
        $string = "По улице ходила большая крокодила. Она, она зелёная была.";
        
        $string = preg_replace("/[^а-яёa-z\s]/iu", '', $string);
        $rowset = explode(' ',$string);
        foreach($rowset as $key=>$item)
        {
            $rowset[$key] = mb_strtolower($item);
        }
        
        foreach($rowset as $key=>$item)
        {
            foreach($rowset as $k=>$i)
            {
                $r[$key]['word'] = $item;
                $r[$key][$k] = 0; 
            }
        }
        
        foreach($rowset as $key=>$item)
        {
            foreach($rowset as $k=>$i)
            {
                if(isset($rowset[$key-2])) $r[$key][$key-2] = 1;
                if(isset($rowset[$key-1])) $r[$key][$key-1] = 2;
                if(isset($rowset[$key+1])) $r[$key][$key+1] = 2;
                if(isset($rowset[$key+2])) $r[$key][$key+2] = 1;  
            }
        }
        
     /*
        foreach($rowset as $key=>$item)
        {
            if(isset($rowset[$key+1]) && $rowset[$key] == $rowset[$key+1])
            {
                foreach($r[$key] as $k=>$i)
                {
                    if(isset($r[$key+1][$k]) && is_int($r[$key+1][$k])){
                        $r[$key][$k] = $r[$key][$k] + $r[$key+1][$k];
                    }
                }
                foreach($r[$key+1] as $k=>$i)
                {
                    if(!isset($r[$key][$k]) && $k != $key){
                        $r[$key][$k] = $r[$key+1][$k];
                    }
                }
                $r[$key][$key+1] = $r[$key][$key+1] + $r[$key+1][$key];
                
                unset($r[$key+1]);
             
                $flag = $key;
                foreach($r as $key=>$item)
                {
                    foreach($r as $k=>$i)
                    {
                        if($key != $flag)
                        {
                            $r[$key][$flag-1] = $r[$key][$flag-1] + $r[$key][$flag];
                            unset($r[$key][$flag]); 
                            goto a;
                        }
                    }
                }
 
            }
        }
        */
        $view = '<table>';
        foreach($r as $key=>$item)
        {
            $view .= '<tr>';
            foreach($item as $k=>$i)
            {
                $view .= '<td>'.$i.'</td>';
            }
            $view .= '</tr>';
        }
        $view .= '</table>';
        echo $view;die;
        //print_r($r);die;
        
        return $this->render('lab2');
    }
    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
