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


class AdminController extends Controller
{
//подтверждение новой информации
public function actionUpdate() {
  //получаем айди компании и json номера контактов
  $request = Yii::$app->request;
  $id = $request->post('id');
  $jsonCount = $request->post('count');

  $contacts = json_decode($jsonCount);

  $sql1 = "";
  $sql2 = "";


  if ($contacts != null) {

    foreach ($contacts as $contact) {
//перенос информации из таблицы обновлений в основную таблицу для контактов
        $sql1.=
          "UPDATE contacts, update_contacts
            SET contacts.name=update_contacts.name
            WHERE contacts.id=update_contacts.cont_id
            AND update_contacts.cont_id = ".$contact." AND update_contacts.name IS NOT NULL;

            UPDATE contacts, update_contacts
            SET contacts.phone=update_contacts.phone
            WHERE contacts.id=update_contacts.cont_id
            AND update_contacts.cont_id = ".$contact." AND update_contacts.phone IS NOT NULL;

            UPDATE contacts, update_contacts
            SET contacts.email=update_contacts.email
            WHERE contacts.id=update_contacts.cont_id
            AND update_contacts.cont_id = ".$contact." AND update_contacts.email IS NOT NULL;

            DELETE FROM update_contacts WHERE cont_id = ".$contact.";";

    }
}
//то же самое для компании
  $sql2 = "UPDATE companies, update_companies
  SET companies.name=update_companies.name
  WHERE companies.id=update_companies.company_id
  AND companies.id = ".$id." AND update_companies.name IS NOT NULL;

  UPDATE companies, update_companies
  SET companies.inn=update_companies.inn
  WHERE companies.id=update_companies.company_id
  AND companies.id = ".$id." AND update_companies.inn IS NOT NULL;

  UPDATE companies, update_companies
  SET companies.ceo=update_companies.ceo
  WHERE companies.id=update_companies.company_id
  AND companies.id = ".$id." AND update_companies.ceo IS NOT NULL;

  UPDATE companies, update_companies
  SET companies.address=update_companies.address
  WHERE companies.id=update_companies.company_id
  AND companies.id = ".$id." AND update_companies.address IS NOT NULL;

  DELETE FROM update_companies WHERE company_id = ".$id.";

  UPDATE companies
  SET status=0 WHERE id = ".$id.";";


      if ($sql1 != "") {

        Yii::$app->db->createCommand($sql1)->execute();

      }

        Yii::$app->db->createCommand($sql2)->execute();


        return "Ok";
      }

//отклонение новой информации
public function actionReject() {
  $request = Yii::$app->request;
  $id = $request->post('id');
  $jsonCount = $request->post('count');

  $contacts = json_decode($jsonCount);

  $sql1 = "";
  $sql2 = "";


  if ($contacts != null) {

      foreach ($contacts as $contact) {
//удаляем информацию из таблицы обновлений для контактов
        $sql1.="DELETE FROM update_contacts WHERE cont_id = ".$contact.";";

      }

    }
//и для компании
  $sql2 = "DELETE FROM update_companies WHERE company_id = ".$id.";
          UPDATE companies
          SET status=0 WHERE id = ".$id.";";

          if ($sql1 != "") {

            Yii::$app->db->createCommand($sql1)->execute();

          }

          Yii::$app->db->createCommand($sql2)->execute();

          return "Ok";
}

public function actionSave(){
  $request = Yii::$app->request;
  $id = $request->post('id');

  $company = Company::findOne($id);
  $company->status = 0;
  $company->save();

return "";

}

public function actionDelete(){

  $request = Yii::$app->request;
  $id = $request->post('id');

  $company = Company::findOne($id);
  if ($company != null) {
  $company->delete();
}

  Contact::deleteAll(['comp_id' => $id]);

  return $this->redirect('/web/companies');

}

}
