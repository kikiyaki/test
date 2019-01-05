<?php
use yii\widgets\LinkPager;
use yii\grid\GridView;
?>
<head>

<style>
.sel {
  width:278px;
}

</style>

</head>

  <h3>
    Список компаний
  </h3>

  <form method="get" action="/web/companies">
    <table>
      <tr>
        <td>
          <input type="text" class="form-control" name="query"
          value="
<?php
if (isset($search)){
echo $search;
}
?>
">
        </td>

        <td>
          <div style="width:5px;">
        </td>

        <td>
          <input class="btn" type="submit" value="Найти">
        </td>
      </tr>
    </table>
</form>

<div style="height:7px">
</div>
<select id="sort" class="form-control sel">
  <option disabled>Сортировать:</option>
  <option value="idd">По номеру</option>
  <option value="inn">По ИНН</option>
  <option value="ttl">По названию</option>
  <option value="sta">По статусу</option>
</select>
</br>

<div id="container">
  <div id="list">

<?php
//вывод таблицы компаний
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => '№',
            'format' => 'raw',
            'value' => function($data){
                return $data['id'];
              }
        ],

        [
        'label' => 'Название',
        'format' => 'raw',
        'value' => function($data){
            return '<a href=/web/company?id='.$data['id'].'>'.
            $data['name'].'</a>';
          }
        ],
//для гостя не показывать статус информации о компании
        Yii::$app->user->isGuest ? (
            ['visible' => '0']
        ) : (
              ['label' => 'Статус',
              'format' => 'raw',
              'value' => function($data){

                  if (!$data['status']) {
                    return '';
                  } else {
                    if ($data['status'] == 1) {
                      return 'Изменен';
                    } else {
                      return 'Новая';
                    }
                  }

                }
              ]
              )
              ,
        [
            'label' => 'ИНН',
            'format' => 'raw',
            'value' => function($data){
                return $data['inn'];
              }
        ],
        [
            'label' => 'Ген. Директор',
            'format' => 'raw',
            'value' => function($data){
                return $data['ceo'];
              }
        ],
        [
            'label' => 'Адрес',
            'format' => 'raw',
            'value' => function($data){
                return $data['address'];
              }
        ]
    ],
]);

?>

  </div>
</div>

<?php

$script = <<< JS

$(document).ready(function(){

var link = window.location.href;
//ищем в текущем Url параметр sort
var pos = link.indexOf('sort');
//если есть, то элементу select ставим соответствующее значение
if (pos > -1) {
  if (link.substr(pos+5, 2)=="tt") {
    $("#sort").val("ttl");
  }

  if (link.substr(pos+5, 2)=="in") {
    $("#sort").val("inn");
  }

  if (link.substr(pos+5, 2)=="id") {
    $("#sort").val("idd");
  }

  if (link.substr(pos+5, 2)=="st") {
    $("#sort").val("sta");
  }
}
//вызывается при изменении select элемента
  $('#sort').change(function(){

    var link = window.location.href;
    var pos = link.indexOf('&sort');
    var selected = $('#sort').find(":selected").val();
//если есть параметр sort в текущем URL, то заменяем его на новый
    if (pos > -1) {
      link=link.substr(0, pos)+link.substr(pos+10);

      link+='&sort='+selected;

    } else {
      var pos1 = link.indexOf('?sort');

      if (pos1 > -1) {
      link=link.substr(0, pos1+6)+selected+link.substr(pos1+9);
    } else {
      var pos2 = link.indexOf('?');

      if (pos2 > -1) {
        link+='&sort='+selected;
      } else {
        link+='?sort='+selected;
      }
    }

    }
//обновляем страницу с новым параметром sort
$(location).attr('href', link);
         });
       });

JS;

$this->registerJs($script);
?>
