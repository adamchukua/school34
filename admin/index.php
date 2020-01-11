<?php 
  require_once "../includes/config.php";


  /* addNews */

  $errors = [];

  $caption = $_POST['caption'];
  $subtitle = $_POST['subtitle'];
  $excerpt = $_POST['excerpt'];
  
  $img_name = false;
  $img = $_FILES['img'];

  if(isset($_POST['submit'])){
    if(trim($caption) == '') {
      $errors[] = 'Введіть назву новини!';
    }

    if(trim($subtitle) == '') {
      $errors[] = 'Опишіть коротку про новину!';
    }

    if(trim($excerpt) == '') {
      $errors[] = 'Напишіть текст новини!';
    }

    if ($img && !$img['error']) {
      $expansions = [
        'image/jpeg' => '.jpg',
        'image/gif' => '.gif',
        'image/png' => '.png'
      ];
      if (isset($expansions[$img['type']])) {
        $img_name = md5_file($img['tmp_name']) . $expansions[$img['type']];
      } else {
        $errors[] = 'Неверное разширение изображения!';
      }
    }

    if(empty($errors)) {
      $request = addNews($caption, $subtitle, $excerpt, $img_name);
      if ($request) {
        if ($img_name) {
          move_uploaded_file($img['tmp_name'], '../img/news/' . $img_name);
        }
      }
    } else {
      echo array_shift($errors);
    }
  }

  
  /* editNews */

  $errors_edit = [];

  $id_edit = $_POST['id_edit'];
  $caption_edit = $_POST['caption_edit'];
  $subtitle_edit = $_POST['subtitle_edit'];
  $excerpt_edit = $_POST['excerpt_edit'];
  
  $img_name_edit = false;
  $img_edit = $_FILES['img_edit'];

  if(isset($_POST['submit_edit'])){
    if(trim($id_edit) == '') {
      $errors_edit[] = 'Введіть id!';
    }

    if(trim($caption_edit) == '') {
      $errors_edit[] = 'Введіть назву новини!';
    }

    if(trim($subtitle_edit) == '') {
      $errors_edit[] = 'Опишіть коротку про новину!';
    }

    if(trim($excerpt_edit) == '') {
      $errors_edit[] = 'Напишіть текст новини!';
    }

    if ($img_edit && !$img_edit['error']) {
      $expansions = [
        'image/jpeg' => '.jpg',
        'image/gif' => '.gif',
        'image/png' => '.png'
      ];
      if (isset($expansions[$img_edit['type']])) {
        $img_name_edit = md5_file($img_edit['tmp_name']) . $expansions[$img_edit['type']];
      } else {
        $errors_edit[] = 'Неверное разширение изображения!';
      }
    }

    if(empty($errors_edit)) {
      $request_edit = editNews($id_edit, $caption_edit, $subtitle_edit, $excerpt_edit, $img_name_edit);
      if ($request_edit) {
        if ($img_name_edit) {
          move_uploaded_file($img_edit['tmp_name'], '../img/news/' . $img_name_edit);
        }
      }
    } else {
      echo array_shift($errors_edit);
    }
  }

  
  /* delNews */

  $errors_del = [];

  $id_del = $_POST['id_del'];

  if(isset($_POST['submit_del'])){
    if(trim($id_del) == '') {
      $errors_edit[] = 'Введіть id!';
    }

    if(empty($errors_del)) {
      $request_del = delNews($id_del);
    } else {
      echo array_shift($errors_del);
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Новини - Адмін панель - Миколаївський заклад загальної середньої освіти №34</title>
  <meta name="description" content="Загальноосвітня школа № 34 - це другий дім для учнів та працівників школи. Ми завжди раді всім хто хоче, буде, або вже навчається в нашій школі.">
  <meta name="keywords" content="мета-теги, шаблон, html, css">
  <meta name="robots" content="index,follow,noodp">
  <meta name="googlebot" content="index,follow">
  <meta name="google" content="nositelinkssearchbox">
  <link rel="stylesheet" href="../css/reset.min.css">
  <link rel="stylesheet" href="../css/main.min.css">
  <link rel="stylesheet" href="../css/admin.min.css">
  <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  
  <meta name="google" content="notranslate"><!-- Подтверждает авторство страницы в Google Search Console -->
  <meta name="robots" content="noindex">
  <meta name="googlebot" content="noindex">

  <link rel="shortcut icon" href="../img/icons/favicon.ico" type="image/x-icon" />
  <link rel="apple-touch-icon" href="../img/icons/apple-touch-icon.png" />
  <link rel="apple-touch-icon" sizes="57x57" href="../img/icons/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon" sizes="72x72" href="../img/icons/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon" sizes="76x76" href="../img/icons/apple-touch-icon-76x76.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="../img/icons/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon" sizes="120x120" href="../img/icons/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon" sizes="144x144" href="../img/icons/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon" sizes="152x152" href="../img/icons/apple-touch-icon-152x152.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="../img/icons/apple-touch-icon-180x180.png" />
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-TileImage" content="../img/icons/mstile-144x144.png">
  <meta name="theme-color" content="#fd333b">
  <meta name="msapplication-navbutton-color" content="#fff">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="#fd333b">
</head>
<body>
  <div class="page">
    <h2 class="page__title">Новини - Адмін панель</h2>
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="index.php">Новини</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="reports.php">Звіти</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="zno.php">ЗНО</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="gallery.php">Галерея</a>
      </li>
    </ul>
    <div class="admin">
      <h3>Додати новину</h3>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="caption">Назва новини</label>
          <input type="text" class="form-control" id="caption" name="caption">
        </div>
        <div class="form-group">
          <label for="subtitle">Коротко про новину</label>
          <input type="text" class="form-control" id="subtitle" name="subtitle">
        </div>
        <div class="form-group">
          <label for="excerpt">Текст новини</label>
          <textarea class="form-control" id="excerpt" rows="3" name="excerpt"></textarea>
        </div>
        <div class="form-group">
          <label for="img">Завантажте зображення</label>
          <input type="file" class="form-control-file" id="img" name="img">
        </div>
        <button type="submit" class="btn btn-primary btn-lg" name="submit">Відправити</button>
      </form>
    </div>
    <div class="admin">
      <h3>Редагувати новину</h3>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="id">ID новини, яку треба редагувати</label>
          <input type="text" class="form-control" id="id" name="id_edit">
        </div>
        <div class="form-group">
          <label for="caption">Назва новини</label>
          <input type="text" class="form-control" id="caption" name="caption_edit">
        </div>
        <div class="form-group">
          <label for="subtitle">Коротко про новину</label>
          <input type="text" class="form-control" id="subtitle" name="subtitle_edit">
        </div>
        <div class="form-group">
          <label for="excerpt">Текст новини</label>
          <textarea class="form-control" id="excerpt" rows="3" name="excerpt_edit"></textarea>
        </div>
        <div class="form-group">
          <label for="img">Завантажте зображення</label>
          <input type="file" class="form-control-file" id="img" name="img_edit">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg" name="submit_edit">Редагувати</button>
        </div>
      </form>
    </div>
    <div class="admin">
      <h3>Видалити новину</h3>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="id">ID новини, яку треба видалити</label>
          <input type="text" class="form-control" id="id" name="id_del">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg" name="submit_del">Видалити</button>
        </div>
      </form>
    </div>
  </div>
  <script src="//code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="../js/main.min.js"></script>
</body>
</html>