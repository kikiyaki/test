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


class EditorController extends Controller
{

//добавление новой информации в таблицы для обновлений
  public function actionUpdate() {
    $request = Yii::$app->request;
//строка, содержащая айди обновляемой компании/контакта, тип обновления,
//номер обновляемого поля
//вида: ID_comp-N или ID_cont-N соответственно для компании или контакта
    $params = $request->post('type');
    $updateText = $request->post('updateText');

    $pos0 = strpos($params, '_')+1;
    $pos1 = strpos($params, '-')-1;

    $type = substr($params, $pos0, 4);
//добавление информации об обновлении компании
    if ($type == "comp") {
      $number = substr($params, $pos0+4, $pos1-$pos0-3);
      $comp_id = substr($params, 0, $pos0-1);

      $company = Company::findOne($comp_id);
      $company->status = 1;
      $company->save();

      $count_comp = Newcompany::find()
            ->where(['company_id' => $comp_id])
            ->count();

            if ($count_comp == 0) {

              $newCompany = new Newcompany();
              $newCompany->company_id = $comp_id;

              switch ($number) {
                case '1':
                  $newCompany->name = $updateText;
                  break;
                case '2':
                  $newCompany->inn = $updateText;
                  break;
                case '3':
                  $newCompany->ceo = $updateText;
                  break;
                case '4':
                  $newCompany->address = $updateText;
                  break;
              }

              $newCompany->save();

      } else {
        $newComp = Newcompany::find()
            ->where(['company_id' => $comp_id])
            ->one();

          switch ($number) {
            case '1':
              $newComp->name = $updateText;
              break;
            case '2':
              $newComp->inn = $updateText;
              break;
            case '3':
              $newComp->ceo = $updateText;
              break;
            case '4':
              $newComp->address = $updateText;
              break;
          }

          $newComp->save();

  }
  return $updateText;
  } else {
//доавление информации об обновлении контакта
      $number = substr($params, $pos0+4, $pos1-$pos0-3);
      $cont_id = substr($params, 0, $pos0-1);
      $contact = Contact::find()
        ->where(['id' => $cont_id])
        ->one();
      $comp_id = $contact->comp_id;

      $company = Company::findOne($comp_id);

      $company->status = 1;
      $company->save();


      $count_cont = Newcontact::find()
            ->where(['cont_id' => $cont_id])
            ->count();

            if ($count_cont == 0) {

        $newContact = new Newcontact();
        $newContact->cont_id = $cont_id;

          switch ($number) {
            case '1':
              $newContact->name = $updateText;
              break;
            case '2':
              $newContact->phone = $updateText;
              break;
            case '3':
              $newContact->email = $updateText;
              break;
          }

          $newContact->save();

        } else {
          $newCont = Newcontact::find()
                ->where(['cont_id' => $cont_id])
                ->one();

          switch ($number) {
            case '1':
              $newCont->name = $updateText;
              break;
            case '2':
              $newCont->phone = $updateText;
              break;
            case '3':
              $newCont->email = $updateText;
              break;
          }

          $newCont->save();

    }

    return $updateText;

  }

  }

public function actionAddcompany() {

    if (!Yii::$app->user->isGuest) {

    return $this->render('addcompany');

  } else {
    return "Нет доступа";
  }
}

public function actionAdd() {

  $request = Yii::$app->request;
  $name = $request->get('name');
  $inn = $request->get('inn');
  $ceo = $request->get('ceo');
  $address = $request->get('address');

  $number = $request->get('number');

  $company = new Company();
  $company->status = 2;
  $company->name = $name;
  $company->inn = $inn;
  $company->ceo = $ceo;
  $company->address = $address;

  $company->save();

  $newComp = Company::find()
      ->where(['inn' => $inn,
              'address' => $address
              ])
      ->one();

  $id = $newComp->id;



  for ($i = 1; $i < $number+1; $i++) {

      $newCont = new Contact();
      $newCont->comp_id = $id;
      $newCont->name = $request->get('name'.$i);
      $newCont->phone = $request->get('number'.$i);
      $newCont->email = $request->get('mail'.$i);

      $newCont->save();
  }

  return $this->redirect('/web/companies');

}

}
