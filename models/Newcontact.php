<?php

namespace app\models;
use yii\db\ActiveRecord;

class Newcontact extends ActiveRecord
{

  public static function tableName()
     {
         return '{{update_contacts}}';
     }

}
