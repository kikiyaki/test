<style>
.width{
  width: 300px;
}

.width_btn{
  width: 150px;
}
</style>

<h2>
Новая компания
</h2>

<h3>
  Имя
</h3>
<form method="GET" action="/web/add">
<input type="text" class="form-control width" name="name">

<h3>
  ИНН
</h3>
<input type="text" class="form-control width" name="inn">

<h3>
  Генеральный директор
</h3>
<input type="text" class="form-control width" name="ceo">

<h3>
  Адрес
</h3>
<input type="text" class="form-control width" name="address">

<div id="contacts">

  <h2>
    Контакты
  </h2>

  <h3>
    Имя
  </h3>
  <input type="text" class="form-control width" name="name1">

  <h3>
    Номер
  </h3>
  <input type="text" class="form-control width" name="number1">

  <h3>
    Почта
  </h3>
  <input type="text" class="form-control width" name="mail1">

</div>
</br>
  <input type="button" class="btn width_btn add"
          id="button1" value="Добавить контакт">
</br>
</br>
  <input type="submit" class="btn width_btn" value="Отправить">
  <input type="text" id="number" name="number" value="1" style="display:none;">

</form>
<?php

$script = <<< JS

$(document).ready(function() {

$(".add").click(function() {

  var id = this.id.substring(6);
  var newId = Number(id)+1;
  this.id = "button".concat(newId);

  var number = document.getElementById("number");
  number.value = newId;

  var div1 = document.createElement("div");
  var titleName = document.createElement("h3");
  titleName.appendChild(document.createTextNode("Имя"));
  div1.appendChild(titleName);

  var div2 = document.createElement("div");
  var titleNumber = document.createElement("h3");
  titleNumber.appendChild(document.createTextNode("Номер"));
  div2.appendChild(titleNumber);

  var div3 = document.createElement("div");
  var titleMail = document.createElement("h3");
  titleMail.appendChild(document.createTextNode("Почта"));
  div3.appendChild(titleMail);

  var div4 = document.createElement("div");
  var inputName = document.createElement("input");
  inputName.type = "text";
  inputName.className = "form-control width";
  inputName.name = "name".concat(newId);
  div4.appendChild(inputName);

  var div5 = document.createElement("div");
  var inputNumber = document.createElement("input");
  inputNumber.type = "text";
  inputNumber.className = "form-control width";
  inputNumber.name = "number".concat(newId);
  div5.appendChild(inputNumber);

  var div6 = document.createElement("div");
  var inputMail = document.createElement("input");
  inputMail.type = "text";
  inputMail.className = "form-control width";
  inputMail.name = "mail".concat(newId);
  div6.appendChild(inputMail);

  var space = document.createElement("div");
  space.style.height = "10px";

  var contacts = document.getElementById("contacts");

  contacts.appendChild(div1);
  contacts.appendChild(div4);
  contacts.appendChild(div2);
  contacts.appendChild(div5);
  contacts.appendChild(div3);
  contacts.appendChild(div6);
});

});

JS;

$this->registerJs($script);

?>
