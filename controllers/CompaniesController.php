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
use  yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class CompaniesController extends Controller
{
//выводит список компаний
public function actionShow() {

  $search = "";
  $dataProvider = null;
  $query = null;
  $request = Yii::$app->request;

    if (null != $request->get('query')) {
//введенная пользователем строка для поиска
      $search = $request->get('query');

      $sql = "(SELECT * FROM companies WHERE (name LIKE '%".$search."%'
      OR inn LIKE '%".$search."%' OR ceo LIKE '%".$search."%'
      OR address LIKE '%".$search."%') ";

      if (Yii::$app->user->isGuest) {
        $sql.= " AND status <> 2 )";
      } else {
        $sql.= ")";
      }

      $sql.=
      "UNION
      (SELECT * FROM companies WHERE id IN
      (SELECT comp_id FROM contacts WHERE name LIKE '%".$search."%'
      OR phone LIKE '%".$search."%' OR email LIKE '%".$search."%')
      )";

      if (null != $request->get('sort')) {
//добавляем к запросу сортировку
        if ($request->get('sort') == 'inn') {
          $sql.=" ORDER BY inn";
        }

        if ($request->get('sort') == 'ttl') {
          $sql.=" ORDER BY name";
        }

        if ($request->get('sort') == 'id') {
        $sql.=" ORDER BY id";
        }

        if ($request->get('sort') == 'sta') {
          $sql.=" ORDER BY status DESC";
        }

      } else {
        $sql.=" ORDER BY id";
      }

      $dataProvider = new SqlDataProvider([
        'sql' => $sql,
        'pagination' => [
        'pageSize' => 5,
    ]
  ]);

      } else {
//если нет поиска то делаем обычный запрос

if (Yii::$app->user->isGuest) {
  if (null != $request->get('sort')) {

  if ($request->get('sort') == 'inn') {
    $query = "SELECT * FROM companies WHERE status <> 2 ORDER BY inn";
  }

  if ($request->get('sort') == 'ttl') {
    $query = "SELECT * FROM companies WHERE status <> 2 ORDER BY name";
  }

  if ($request->get('sort') == 'idd') {
    $query = "SELECT * FROM companies WHERE status <> 2 ORDER BY id";
  }

  if ($request->get('sort') == 'sta') {
    $query = "SELECT * FROM companies WHERE status=1
    UNION
    (SELECT * FROM companies WHERE status=0)";
  }
} else {
  $query = "SELECT * FROM companies WHERE status <> 2 ORDER BY id";
}
} else {
  if (null != $request->get('sort')) {

  if ($request->get('sort') == 'inn') {
    $query = "SELECT * FROM companies ORDER BY inn";
  }

  if ($request->get('sort') == 'ttl') {
    $query = "SELECT * FROM companies ORDER BY name";
  }

  if ($request->get('sort') == 'idd') {
    $query = "SELECT * FROM companies ORDER BY id";
  }

  if ($request->get('sort') == 'sta') {
    $query = "SELECT * FROM companies WHERE status=2
UNION
(SELECT * FROM companies WHERE status=1)
UNION
(SELECT * FROM companies WHERE status=0)";

  }
} else {
  $query = "SELECT * FROM companies";
}
}

    $dataProvider = new SqlDataProvider([
        'sql' => $query,
        'pagination' => [
        'pageSize' => 5,
      ],
    ]);

    }

    return $this->render('list', [
      'dataProvider' => $dataProvider,
      'search' => $search
    ]
    );

}

}
