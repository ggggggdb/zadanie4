<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['checkbox'] = !empty($_COOKIE['checkbox_error']);
  $errors['bdate'] = !empty($_COOKIE['bdate_error']);
  $errors['superpowers'] = !empty($_COOKIE['superpowers_error']);
  
  //email, bdate, gender, limbs, superpowers, bio
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['name'] == '1') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя</div>';
  }
  else if ($errors['name'] == '1') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Используйте латинский алфавит или "-"</div>';
  }
  if ($errors['email'] == '1') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните email</div>';
  }
  else if ($errors['email'] == '2') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните email в формате test@test.com</div>';
  }
  else if ($errors['email'] == '3') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Используйте английский алфавит и цифры</div>';
  }
  if ($errors['limbs']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limbs_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните число конечностей</div>';
  }
  if ($errors['gender']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните пол</div>';
  }
  if ($errors['bio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните биографию</div>';
  }
  if ($errors['superpowers']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('superpowers_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Нелегальная сверхспособность</div>';
  }
  if ($errors['bdate']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bdate_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите год рождения</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['bdate'] = empty($_COOKIE['bdate_value']) ? '' : $_COOKIE['bdate_value'];
  $superpowers = empty($_COOKIE['superpowers_value']) ? '' : $_COOKIE['superpowers_values'];
  $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : $_COOKIE['checkbox_value'];
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле name.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if (!preg_match("/[\w-]+/i", $_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле name.
    setcookie('name_error', '2', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле email.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }

  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['gender'])) {
    // Выдаем куку на день с флажком об ошибке в поле gender.
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['limbs'])) {
    // Выдаем куку на день с флажком об ошибке в поле limbs.
    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['bio'])) {
    // Выдаем куку на день с флажком об ошибке в поле bio.
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['checkbox'])) {
    // Выдаем куку на день с флажком об ошибке в поле checkbox.
    setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['bdate'])) {
    // Выдаем куку на день с флажком об ошибке в поле bdate.
    setcookie('bdate_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('bdate_value', $_POST['bdate'], time() + 30 * 24 * 60 * 60);
  }
  if (!empty($_POST['superpowers']) && !preg_match("/Бессмертие|Прохождение сквозь стены|Левитация/", implode(",", $_POST['superpowers']))) {
    // Выдаем куку на день с флажком об ошибке в поле superpowers.
    setcookie('superpowers_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('superpowers_value', $_POST['superpowers'], time() + 30 * 24 * 60 * 60);
  }

// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('bdate_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('superpowers_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('checkbox_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
  }

  // Сохранение в XML-документ.
  // ...
  $user = 'u47502';
  $pass = '8701243';
  $db = new PDO('mysql:host=localhost;dbname=u47502', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  $stmt1 = $db->prepare("INSERT INTO form SET name = ?, email = ?, bdate = ?, gender = ?, limbs = ?, bio = ?;");
  $stmt1 -> execute([
    $_POST['name'],
    strtolower($_POST['e-mail']),
    $_POST['bdate'],
    $_POST['gender'],
    $_POST['limbs'],
    $_POST['bio']
  ]);
  $stmt2 = $db->prepare("INSERT INTO super SET id = ?, ability = ?;");
  $id = $db->lastInsertId();
  foreach ($_POST['superpowers'] as $s)
    $stmt2 -> execute([$id, $s]);
  echo "Данные успешно сохранены." . $id;

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
