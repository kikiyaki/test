<head>

<style>
.green {
  background: #9f9;
}
.red {
  background: #f99;
}
</style>

</head>
<h2>
<?php
use yii\widgets\DetailView;

if ($company == null) {
  echo "Компаниии нет в базе либо она была удалена";
} else {

if (Yii::$app->user->isGuest) {
  $new_company = null;
  $new_contacts = null;
}
if (Yii::$app->user->isGuest && $company['status'] == 2) {

} else {

  if ($company['status'] == 2){
    echo "Новая компания: ";
  }

echo $company->name;
}
?>
</h2>
<h3>
  #
<?php
if (Yii::$app->user->isGuest && $company['status'] == 2) {
  echo "Информация не подтверждена";
} else {
  echo $company->id;
}
?>
</h3>

<?php
$jsonCount = "";
if (Yii::$app->user->isGuest && $company['status'] == 2) {

} else {

//вывод таблицы с информацией о компании
echo DetailView::widget([
    'model' => $company,
    'attributes' => [
        [
            'label' => '№',
            'attribute' => 'id',
            'captionOptions' => ['width' => '250px'],
        ],

        Yii::$app->user->isGuest ? (
          [
              'label' => 'Наименование',
              'format' => 'raw',
              'value' => function($data){
                return $data->name;
        }
        ]
          ) : (
        [
            'label' => 'Наименование',
            'format' => 'raw',
            'value' => function($data){
        return '<div id='."'".$data->id."_comp1-div'".'>'
        .$data->name." <input type='button' class='comp btn'
                id='".$data->id."_comp1-' value='Ред.'/>"
        .'</div>';
      }
      ]
    ),
//если есть новая информация, то отобразить ее
        $new_company != null &&
        $new_company['name'] != null ? (
          [
              'label' => 'Новое наименование',
              'format' => 'raw',
              'value' =>  $new_company['name'],
              'contentOptions' => ['style'=>'background:#f99']

          ]
          ) : (
            ['visible' => '0']
            )
        ,
//если текущий пользователь гость, то выводим только информацию, без возможности редактирования
        Yii::$app->user->isGuest ? (
          [
              'label' => 'ИНН',
              'format' => 'raw',
              'value' => function($data){
          return $data->inn;
        }
      ]
          ) : (
            [
                'label' => 'ИНН',
                'format' => 'raw',
                'value' => function($data){
            return '<div id='."'".$data->id."_comp2-div'".'>'
            .$data->inn."  <input type='button' class='comp btn'
                    id='".$data->id."_comp2-' value='Ред.'/>"
            .'</div>';
          }
        ]
    ),

        $new_company != null &&
        $new_company['inn'] != null ? (
          [
              'label' => 'Новый ИНН',
              'format' => 'raw',
              'value' =>  $new_company['inn'],
              'contentOptions' => ['style'=>'background:#f99']
          ]
          ) : (
            ['visible' => '0']
            )
        ,

        Yii::$app->user->isGuest ? (
          [
            'label' => 'Генеральный директор',
            'format' => 'raw',
            'value' => function($data){
              return $data->ceo;
            }
        ]
          ) : (
            [
                'label' => 'Генеральный директор',
                'format' => 'raw',
                'value' => function($data){
            return '<div id='."'".$data->id."_comp3-div'".'>'
            .$data->ceo."  <input type='button' class='comp btn'
                    id='".$data->id."_comp3-' value='Ред.'/>"
            .'</div>';
          }
            ]
        ),

        $new_company != null &&
        $new_company['ceo'] != null ? (
          [
              'label' => 'Новый Ген. Директор',
              'format' => 'raw',
              'value' =>  $new_company['ceo'],
              'contentOptions' => ['style'=>'background:#f99']

          ]
          ) : (
            ['visible' => '0']
            )
        ,

        Yii::$app->user->isGuest ? (
          [
              'label' => 'Адрес',
              'format' => 'raw',
              'value' => function($data){
          return $data->address;
        }
          ]
          ) : (
            [
                'label' => 'Адрес',
                'format' => 'raw',
                'value' => function($data){
            return '<div id='."'".$data->id."_comp4-div'".'>'
            .$data->address."  <input type='button' class='comp btn'
                    id='".$data->id."_comp4-' value='Ред.'/>"
            .'</div>';
          }
            ]
        ),

        $new_company != null &&
        $new_company['address'] != null ? (
          [
              'label' => 'Новый адрес',
              'format' => 'raw',
              'value' =>  $new_company['address'],
              'contentOptions' => ['style'=>'background:#f99']
          ]
          ) : (
            ['visible' => '0']
            )
        ,

    ],
]);
?>

<h3>
Контакты
</h3>

<?php

$count_ids = [];
if ($new_contacts != null) {
  foreach ($new_contacts as $new_contact) {
    $count_ids[] = $new_contact->cont_id;
  }
}

$jsonCount = json_encode($count_ids);

  foreach ($contacts as $contact) {

    $newName = null;
    $newPhone = null;
    $newEmail = null;

    if ($new_contacts != null) {

    foreach ($new_contacts as $new_contact) {

      if ($contact->id == $new_contact->cont_id) {

        if ($new_contact->name != null)
          $newName = $new_contact->name;

          if ($new_contact->phone != null)
            $newPhone = $new_contact->phone;

            if ($new_contact->email != null)
              $newEmail = $new_contact->email;
      }
    }
  }
  //вывод информации о контактах
  echo DetailView::widget([
      'model' => $contact,
      'attributes' => [

        Yii::$app->user->isGuest ? (
          [
              'label' => 'Имя',
              'format' => 'raw',
              'captionOptions' => ['width' => '250px'],
              'value' => function($data){
                return $data->name;
        }
          ]
          ) : (
            [
                'label' => 'Имя',
                'format' => 'raw',
                'captionOptions' => ['width' => '250px'],
                'value' => function($data){
            return '<div id='."'".$data->id."_cont1-div'".'>'
            .$data->name."  <input type='button' class='comp btn'
                    id='".$data->id."_cont1-' value='Ред.'/>"
            .'</div>';
          }
            ]
        )
        ,
          $newName != null ?
           (
            [
                'label' => 'Новое имя',
                'format' => 'raw',
                'value' =>  $newName,
                'contentOptions' => ['style'=>'background:#f99']
            ]
            ) : (
              ['visible' => '0']
              )
          ,

          Yii::$app->user->isGuest ? (
            [
                'label' => 'Телефон',
                'format' => 'raw',
                'value' => function($data){
                  return $data->phone;
          }
            ]
            ) : (
              [
                  'label' => 'Телефон',
                  'format' => 'raw',
                  'value' => function($data){
              return '<div id='."'".$data->id."_cont2-div'".'>'
              .$data->phone."  <input type='button' class='comp btn'
                      id='".$data->id."_cont2-' value='Ред.'/>"
              .'</div>';
            }
              ]
              )
          ,
          $newPhone != null ?
           (
            [
                'label' => 'Новый телефон',
                'format' => 'raw',
                'value' =>  $newPhone,
                'contentOptions' => ['style'=>'background:#f99']

            ]
            ) : (
              ['visible' => '0']
              )
          ,
          Yii::$app->user->isGuest ? (
            [
                'label' => 'Почта',
                'format' => 'raw',
                'value' => function($data){
            return $data->email;
          }
            ]
            ) : (
              [
                  'label' => 'Почта',
                  'format' => 'raw',
                  'value' => function($data){
              return '<div id='."'".$data->id."_cont3-div'".'>'
              .$data->email."  <input type='button' class='comp btn'
                      id='".$data->id."_cont3-' value='Ред.'/>"
              .'</div>';
            }
              ]
              )
          ,
          $newEmail != null ?
           (
            [
                'label' => 'Новая почта',
                'format' => 'raw',
                'value' =>  $newEmail,
                'contentOptions' => ['style'=>'background:#f99']
            ]
            ) : (
              ['visible' => '0']
              )
          ,
      ],
  ]);
}

}

$script = <<< JS

$(document).ready(function(){
//вызывается при клике по кнопке редактировать
$(".comp").click(function() {
      var divId = this.id+"div";
      var div = document.getElementById(divId);
//выводится поле для ввода текста
      div.innerHTML ="<table><tr>"+
            "<td>"+
            "<input type='text' class='form-control' id='"+divId+"text"+"'>"+
            "</td>"+
            "<td>"+
            "<div style='width:10px;'></div>"+
            "</td>"+
            "<td>"+
            "<button id="+divId+" class='compSend btn'>Ок</button>"+
            "</td>"+
            "</tr></table>"
            ;
//вызывается для отправки изменения на сервер
            $(".compSend").click(function() {
                  var updateText = document.getElementById(divId+"text").value;

                  $.ajax({
                           url: '/web/update',
                           type: 'POST',
                           data: {
                             updateText:updateText,
                             type:divId
                           },
                           success: function(res){
                              div.innerHTML = res;
                              div.style.color = "red";
                           },
                           error: function(){
                               alert('Error!');
                           }
                       });
            });
});
//клик по кнопке принятия изменения Админом
$("#aply").click(function() {

  $.ajax({
           url: '/web/updateadmin',
           type: 'POST',
           data: {
             id: $company->id,
             count: '$jsonCount'
           },
           success: function(res){
             var link = window.location.href;
             $(location).attr('href', link);
           },
           error: function(){
               alert('Error!');
           }
       });
});

//клик по кнопке отклонения изменения Админом
$("#reject").click(function() {

  $.ajax({
           url: '/web/reject',
           type: 'POST',
           data: {
             id: $company->id,
             count: '$jsonCount'
           },
           success: function(res){
             var link = window.location.href;
             $(location).attr('href', link);
           },
           error: function(){
               alert('Error!');
           }
       });
});

//клик по кнопке принять компанию Админом
$("#aply_company").click(function() {

  $.ajax({
           url: '/web/save_new_company',
           type: 'POST',
           data: {
             id: $company->id,
           },
           success: function(res){
             var link = window.location.href;
             $(location).attr('href', link);
           },
           error: function(){
               alert('Error!');
           }
       });
});

//клик по кнопке отклонить компанию Админом
$("#reject_company").click(function() {

  $.ajax({
           url: '/web/delete_new_company',
           type: 'POST',
           data: {
             id: $company->id,
           },
           success: function(res){
             var link = window.location.href;
             $(location).attr('href', link);
           },
           error: function(){
           }
       });
});

});

JS;

$this->registerJs($script);

if (Yii::$app->user->identity != null &&
    Yii::$app->user->identity->role == 1&&
    ($new_company != null || $new_contacts != null)) {
  echo '<button id="aply" class="btn green">Принять изменения</button>  ';
  echo '<button id="reject" class="btn red">Отклонить</button>';
  echo '</br>';
}

if (Yii::$app->user->identity != null &&
    Yii::$app->user->identity->role == 1) {
    if ($company->status == 2) {
      echo '</br>';
      echo '<button id="aply_company" class="btn green">Принять компанию</button>  ';
      echo '<button id="reject_company" class="btn red">Отклонить</button>';
  } else {
      echo '</br>';
      echo '<button id="reject_company" class="btn red">Удалить компанию</button>';
  }
}
}

?>
