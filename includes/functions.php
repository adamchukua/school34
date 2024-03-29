<?php

function getConnection() {
    $db = mysqli_connect(HOST, USER, PASS, DB);
    mysqli_query($db, "SET NAMES utf8");
    return $db;
}

/*function getAssocResult($sql) {
    $db = getConnection();
    $result = mysqli_query($db, $sql);
    $array_result = array();
    while($row = mysqli_fetch_assoc($result)){
        $array_result[] = $row;
    }
    mysqli_close($db);
    return $array_result;
}

function executeQuery($sql, $db = null) {
    if(!$db){
        $db = getConnection();
    }

    $result = mysqli_query($db, $sql);

    echo mysqli_error($db);
    mysqli_close($db);
    return $result;
}*/

function prepareSqlString($link, $value) {
    return mysqli_real_escape_string(
        $link,
        (string)htmlspecialchars( strip_tags($value) )
    );
}

function execQuery($sql) {
    $db = getConnection();

    $result = mysqli_query($db, $sql);

    mysqli_close($db);
    return $result;
}

function reArrayFiles($file) {
    $file_ary = array();
    $file_count = count($file['name']);
    $file_key = array_keys($file);
   
    for($i = 0; $i < $file_count; $i++) {
        foreach($file_key as $val) {
            $file_ary[$i][$val] = $file[$val][$i];
        }
    }

    return $file_ary;
}

function pagination_render($str_pag, $page) {
  if ($str_pag >= 6) {
    $prev_page = $page - 1;
    $next_page = $page + 1;

    $i = $_GET['page'];

    if ($i == 1) {
      echo "<div class='pagination__item'><a class='pagination__link pagination__link_active' href=index.php?page=1>1</a></div>";
    } else {
      echo "<div class='pagination__item'><a class='pagination__link' href=index.php?page=1>1</a></div>";
    }
    if ($page - 1 > 2) {
      echo "<div class='pagination__item'>...</div>";
    }
    if ($prev_page != 0 && $prev_page != 1) {
      echo "<div class='pagination__item'><a class='pagination__link' href=index.php?page=$prev_page>$prev_page</a></div>";
    }
    if ($page != 1 && $page != $str_pag) {
      if ($page == $i) {
          echo "<div class='pagination__item'><a class='pagination__link pagination__link_active' href=index.php?page=$page>$page</a></div>";
      } else {
        echo "<div class='pagination__item'><a class='pagination__link' href=index.php?page=$page>$page</a></div>";
      }
    }
    if ($page != $str_pag && $page != $str_pag - 1) {
      echo "<div class='pagination__item'><a class='pagination__link' href=index.php?page=$next_page>$next_page</a></div>";
    }
    if ($str_pag - $page > 2) {
      echo "<div class='pagination__item'>...</div>";
    }
    if ($i == $str_pag) {
      echo "<div class='pagination__item'><a class='pagination__link pagination__link_active' href=index.php?page=$str_pag>$str_pag</a></div>";
    } else {
      echo "<div class='pagination__item'><a class='pagination__link' href=index.php?page=$str_pag>$str_pag</a></div>";
    }
  } else {
    for ($i = 1; $i <= $str_pag; $i++){
      if ($str_pag != 1) {
        if ($page == $i) {
          echo "<div class='pagination__item'><a class='pagination__link pagination__link_active' href=index.php?page=$i>$i</a></div>";
        } else {
          echo "<div class='pagination__item'><a class='pagination__link' href=index.php?page=$i>$i</a></div>";
        }
      }
    }
  }
}

function dateUa($month) {
    if ($month == '01') {
        return 'січня';
    } elseif ($month == '02') {
        return 'лютого';
    } elseif ($month == '03') {
        return 'березня';
    } elseif ($month == '04') {
        return 'квітня';
    } elseif ($month == '05') {
        return 'травня';
    } elseif ($month == '06') {
        return 'червня';
    } elseif ($month == '07') {
        return 'липня';
    } elseif ($month == '08') {
        return 'серпня';
    } elseif ($month == '09') {
        return 'вересня';
    } elseif ($month == '10') {
        return 'жовтня';
    } elseif ($month == '11') {
        return 'листопада';
    } elseif ($month == '12') {
        return 'грудня';
    }
}

function friendlyDate($date, $type = "datetime") {
    $friendlyDate = "";
    
    $year = substr($date, 0, 4);
    $month = substr($date, 5, 2);
    $day = substr($date, 8, 3);
    $time = substr($date, 10, 6);

    if ($type == "datetime") {
        $friendlyDate = $day . " " . dateUa($month) . " " . $year . ", " . $time;
    } elseif ($type == "date") {
        $friendlyDate = $day . " " . dateUa($month) . " " . $year;
    }

    if ($friendlyDate == "  , ") {
        $friendlyDate = "";
    }

    return $friendlyDate;
}

function addNews($caption, $subtitle, $excerpt, $caption_img_name) {
    $link = getConnection();
   
    $caption = prepareSqlString($link, $caption);
    $subtitle = prepareSqlString($link, $subtitle);
    $caption_img_name = prepareSqlString($link, $caption_img_name);

    $sql = "INSERT INTO `news` (`caption`, `subtitle`, `excerpt`, `caption-img`) VALUES ('$caption', '$subtitle', '$excerpt', '$caption_img_name')";

    $result = execQuery($sql, $link);
    
    return $result;
}

function editNews($id, $caption, $subtitle, $excerpt, $caption_img_name) {
    $link = getConnection();
   
    $id = prepareSqlString($link, $id);
    $caption = prepareSqlString($link, $caption);
    $subtitle = prepareSqlString($link, $subtitle);
    $caption_img_name = prepareSqlString($link, $caption_img_name);

    $sql = "UPDATE `news` SET ";

    if ($caption) {
        $sql .= "`caption` = '$caption'";
        if ($subtitle) {
            $sql .= ", ";
        }
    }
    if ($subtitle) {
        $sql .= "`subtitle` = '$subtitle'";
        if ($caption_img_name) {
            $sql .= ", ";
        }
    }
    if ($caption_img_name) {
        $sql .= "`caption-img` = '$caption_img_name'";
        if ($excerpt) {
            $sql .= ", ";
        }
    }
    if ($excerpt) {
        if ($caption_img_name || $subtitle || $caption) {
            $sql .= ", ";
        }
        $sql .= "`excerpt` = '$excerpt'";
    }

    $sql .= " WHERE `id` = '$id'";

    $result = execQuery($sql, $link);
    
    return $result;
}

function delNews($id) {
    $link = getConnection();
   
    $id = prepareSqlString($link, $id);

    $sql = "DELETE FROM `news` WHERE `id` = $id";

    $result = execQuery($sql, $link);
    
    return $result;
}

function addReport($caption, $subtitle, $siteLink) {
    $link = getConnection();
   
    $caption = prepareSqlString($link, $caption);
    $subtitle = prepareSqlString($link, $subtitle);
    $siteLink = prepareSqlString($link, $siteLink);

    $sql = "INSERT INTO `reports` (`caption`, `subtitle`, `link`) VALUES ('$caption', '$subtitle', '$siteLink')";

    $result = execQuery($sql, $link);
    
    return $result;
}

function editReport($id, $caption, $subtitle, $siteLink) {
    $link = getConnection();
   
    $id = prepareSqlString($link, $id);
    $caption = prepareSqlString($link, $caption);
    $subtitle = prepareSqlString($link, $subtitle);
    $siteLink = prepareSqlString($link, $siteLink);

    $sql = "UPDATE `reports` SET ";

    if ($caption) {
        $sql .= "`caption` = '$caption'";
        if ($subtitle) {
            $sql .= ", ";
        }
    }
    if ($subtitle) {
        $sql .= "`subtitle` = '$subtitle'";
        if ($siteLink) {
            $sql .= ", ";
        }
    }
    if ($siteLink) {
        if ($subtitle || $caption) {
            $sql .= ", ";
        }
        $sql .= "`link` = '$siteLink'";
    }

    $sql .= " WHERE `id` = '$id'";

    $result = execQuery($sql, $link);
    
    return $result;
}

function delReport($id) {
    $link = getConnection();
   
    $id = prepareSqlString($link, $id);

    $sql = "DELETE FROM `reports` WHERE `id` = $id";

    $result = execQuery($sql, $link);
    
    return $result;
}

function addZno($caption, $subtitle, $excerpt, $caption_img_name) {
    $link = getConnection();
   
    $caption = prepareSqlString($link, $caption);
    $subtitle = prepareSqlString($link, $subtitle);
    $caption_img_name = prepareSqlString($link, $caption_img_name);

    $sql = "INSERT INTO `zno` (`caption`, `subtitle`, `excerpt`, `caption-img`) VALUES ('$caption', '$subtitle', '$excerpt', '$caption_img_name')";

    $result = execQuery($sql, $link);
    
    return $result;
}

function editZno($id, $caption, $subtitle, $excerpt, $img_name) {
    $link = getConnection();
   
    $id = prepareSqlString($link, $id);
    $caption = prepareSqlString($link, $caption);
    $subtitle = prepareSqlString($link, $subtitle);
    $img_name = prepareSqlString($link, $img_name);

    $sql = "UPDATE `zno` SET ";

    if ($caption) {
        $sql .= "`caption` = '$caption'";
        if ($subtitle) {
            $sql .= ", ";
        }
    }
    if ($subtitle) {
        $sql .= "`subtitle` = '$subtitle'";
        if ($img_name) {
            $sql .= ", ";
        }
    }
    if ($img_name) {
        $sql .= "`img` = '$img_name'";
        if ($excerpt) {
            $sql .= ", ";
        }
    }
    if ($excerpt) {
        if ($img_name || $subtitle || $caption) {
            $sql .= ", ";
        }
        $sql .= "`excerpt` = '$excerpt'";
    }

    $sql .= " WHERE `id` = '$id'";

    $result = execQuery($sql, $link);
    
    return $result;
}

function delZno($id) {
    $link = getConnection();
   
    $id = prepareSqlString($link, $id);

    $sql = "DELETE FROM `zno` WHERE `id` = $id";

    $result = execQuery($sql, $link);
    
    return $result;
}

function addPart($caption, $caption_img_name) {
    $link = getConnection();
   
    $caption = prepareSqlString($link, $caption);
    $caption_img_name = prepareSqlString($link, $caption_img_name);

    $sql = "INSERT INTO `info_pages` (`name`, `icon`) VALUES ($caption, $caption_img_name)";

    

    $result = execQuery($sql, $link);
    
    return $result;
}

function generateRandomString($length = 30) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function existingEmail($address) {
    $link = getConnection();

    $sql = "SELECT `address` FROM `emails` WHERE EXISTS (SELECT `address` FROM `emails` WHERE `address` = '$address')";

    $result = execQuery($sql, $link);
    
    return $result;
}

function addEmail($data) {
    $link = getConnection();

    $address = $data['email'];

    $address = prepareSqlString($link, $address);
    $check = existingEmail($address);

    if ($check->num_rows == 0) {
        $token = generateRandomString();

        $sql = "INSERT INTO `emails` (`address`, `token`) VALUES ('$address', '$token')";

        $result = execQuery($sql, $link);

        ini_set("SMTP", "aspmx.l.google.com");
        ini_set("sendmail_from", "school34@gmail.com");

        $site_url = "http://" . $_SERVER['HTTP_HOST'];
        $message = file_get_contents($site_url . '/templates/email.php');

        $headers = "From: school34@gmail.com\r\n".
                   "MIME-Version: 1.0" . "\r\n" .
                   "Content-type: text/html; charset=UTF-8" . "\r\n"; 

        mail("$address", "Підтвердіть email розсилку! 😉", $message, $headers);
    }

    return $result;
}

function confirmEmail($token) {
    $link = getConnection();

    $token = prepareSqlString($link, $token);

    $sql = "UPDATE `emails` SET `verified` = '1', `token` = null WHERE `token` = '$token'";

    $result = execQuery($sql, $link);

    return $result;
}