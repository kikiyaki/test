<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */

//вывод страницы для входа
    public function actionLogin()
      {

        return $this->render('login');
      }

//аутентификация пользователя
    public function actionLog()
      {
        $request = Yii::$app->request;

        $login = $request->post('login');
        $pass = $request->post('pass');

        $user = User::findOne([
          'name' => $login,
        ]);

          if ($user != null) {

              if ($user->pass == $pass) {

              Yii::$app->user->login($user);
            return $this->redirect('/web/companies');

              } else {

                return $this->render('login',
                  ['message' => 'Неверный пароль',
                  'login' => $login]
                );
              }
          } else {

            return $this->render('login',
            ['message' => 'Нету такого пользователя',
            'login' => $login]
            );
          }
      }

      public function actionOut() {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->request->referrer);
      }

      public function actionTest() {
        if (Yii::$app->user->isGuest){
          return "guest";
        } else {
          return Yii::$app->user->identity->role;
        }
      }

    /**
     * Logout action.
     *
     * @return Response
     */


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
