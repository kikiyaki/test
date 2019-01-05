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
use app\models\Company;
use app\models\Newcompany;
use app\models\Contact;
use app\models\Newcontact;


class CompanyController extends Controller
{
public function actionShow(){

  $request = Yii::$app->request;
  $id = $request->get('id');

  $new_company = null;
  $new_contacts = null;
//ищем одну запись компании
  $company = Company::find()
        ->where(['id' => $id])
        ->limit(1)
        ->one();
//проверка есть ли запись о данной компании в таблице обновлений
  if(Newcompany::find()
              ->where(['company_id' => $id])
              ->count()
              == 1
            ) {
//если есть, то достаем запись
              $new_company = Newcompany::find()
                          ->where(['company_id' => $id])
                          ->limit(1)
                          ->one();
            }
//количество контактов о данной компании в таблице обновлений
            $sql1 = "SELECT COUNT(*) AS 'user_id' FROM update_contacts
            WHERE cont_id IN (SELECT id FROM contacts WHERE comp_id=".$id.");";
//запрос информации о контактах из таблицы обновлений
            $sql2 = 'SELECT * FROM update_contacts
            WHERE cont_id IN (SELECT id FROM contacts WHERE comp_id='.$id.');';

            if(Newcontact::findBySql($sql1)->one()->user_id
                        > 0
                      ) {
                        $new_contacts = Newcontact::findBySql($sql2)
                                      ->all();
                      }

  $contacts = Contact::find()
              ->where(['comp_id' => $id])
              ->all();

return $this->render('company', [
        'company' => $company,//запись о данной компании
        'contacts' => $contacts,//все записи о контактах данной компании
        'new_company' => $new_company,//запись о компании из таблицы обновлений
        'new_contacts' => $new_contacts//контакты из таблицы обновлений
    ]);
}

}
