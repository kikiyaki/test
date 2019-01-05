<?php

namespace app\models;
use yii\db\ActiveRecord;

class Newcompany extends ActiveRecord
{

  public static function tableName()
     {
         return '{{update_companies}}';
     }

}
