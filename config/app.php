<?php

use Core\DB;
use Core\Library\MailSend;

const APP_CONFIG = [
    'url' => 'http://localhost/project/',
    'static' => 'http://localhost/project/resources/static/',
    'uploads' => 'http://localhost/project/uploads/',
];

// const MAIL_CONFIG = [
//     'server' => 'smtp.gmail.com',
//     'port' => 587,
//     'username' => '',
//     'password' => '',
// ];

const MAIL_CONFIG = [
    'server' => 'mx2166.tino.org',
    'port' => 587,
    'username' => '',
    'password' => '',
    'from' => 'admin@fpt.edu.vn',
    'fromName' => 'FPT Polytechnic'
];


function request($name)
{
    return isset($_REQUEST[$name]) ? htmlspecialchars(strip_tags(trim($_REQUEST[$name]))) : false;
}

function fileRequest($name)
{
    return isset($_FILES[$name]) ? $_FILES[$name] : false;
}

function redirect($path, $httpCode = 301)
{
    if (!headers_sent()) {
        header("Location: " . APP_CONFIG["url"] . $path, TRUE, $httpCode);
        exit(0);
    }

    exit('<meta http-equiv="refresh" content="0; url=' . $path . '"/>');
}

function layout($name, $data = [])
{
    extract($data);
    $name = str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';
    $path = "resources/views/$name";
    if (file_exists($path)) {
        return include_once($path);
    }
    return false;
}

function view($name, $data = [])
{
    extract($data);
    $name = str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';
    if (file_exists("resources/views/$name")) {
        include_once("resources/views/$name");
    }
}

function csrf_field()
{
    echo '<input type="hidden" name="csrf_token" id="csrf_token" value="' . csrf_token() . '">';
}

function csrf_token()
{
    if (!isset($_SESSION["csrf_token"])) {
        $token = base64_encode(openssl_random_pseudo_bytes(32));
        $_SESSION["csrf_token"] = $token;
    } else {
        $token = $_SESSION["csrf_token"];
    }
    return $token;
}

function csrf_verify($token)
{
    if (isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] == $token) {
        //unset($_SESSION["csrf_token"]);
        return true;
    }
    //unset($_SESSION["csrf_token"]);
    return false;
}


function setSession($name, $param)
{
    $_SESSION[$name] = $param;
}

function getSession($name)
{
    return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
}

function getSessionAll()
{
    return $_SESSION;
}

function destroySession($name = '')
{
    if ($name == '') {
        return session_destroy();
    }
    unset($_SESSION[$name]);
    return true;
}

function setCookies($name, $value, $date = 1 * 60 * 60 * 24)
{
    $dateNow = time() + $date;
    $y = date("Y", $dateNow);
    $m = date("m", $dateNow);
    $d = date("d", $dateNow);
    $time = mktime(0, 0, 0, $m, $d, $y);

    return setcookie($name, $value, $time, "/");
}

function getCookies($name)
{
    return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : '[]';
}

function deleteCookies($name){
    return setcookie($name, 'MokaDEV', time() - 100, "/");
}

function uploadFile($data, array $type = [])
{
    if ($data['size'] > 1500000) {
        return 'size';
    }

    if (in_array($data['type'], $type)) {
        $nameArr = explode(".", $data['name']);
        $fileName = (md5($nameArr[0]) . "_" . time() . "." . $nameArr[1]);
        $result = move_uploaded_file($data['tmp_name'], 'uploads/' . $fileName);
        if (!$result) {
            $fileName = '';
        }
        return $fileName;
    }
    return false;
}

function now($format = "Y-m-d H:i:s")
{
    return date($format);
}

function price($number)
{
    return number_format($number, 0, '', ',') . " VNĐ";
}

function sale($number, $sale)
{
    return ($sale == 0) ? price($number) : price($number - ($number * ($sale / 100))) . " <span>" . price($number) . "</span>";
}

function pagination($total, $page)
{
    $prev = "<li class=\"page-item " . (($page > 1 && $total > 1) ? "" : "disabled") . "\">
                <a class=\"page-link\" href=\"?page=" . ($page - 1) . "\">
                    <i class=\"fas fa-angle-left\"></i>
                    <span class=\"sr-only\">Previous</span>
                </a>
            </li>";
    $next = "<li class=\"page-item " . (($page < $total && $total > 1) ? '' : 'disabled') . "\">
                <a class=\"page-link\" href=\"?page=" . ($page + 1) . "\">
                    <i class=\"fas fa-angle-right\"></i>
                    <span class=\"sr-only\">Next</span>
                </a>
            </li>";

    $pageCount = "";

    $pageCount .= ($page - 2) > 1 ? '<li class="page-item"><a class="page-link" href="#">...</a></li>' : '';
    for ($i = ($page - 2) > 0 ? ($page - 2) : 1; $i <= (($page + 2) > $total ? $total : ($page + 2)); $i++) {
        if ($i == $page) {
            $pageCount .= '<li class="page-item active"><a class="page-link" href="">' . $i . '</a></li>';
        } else {
            $pageCount .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }
    $pageCount .= ($page + 2) < $total ? '<li class="page-item"><a class="page-link" href="#">...</a></li>' : '';
    return '<div class="card-footer py-4">
                <nav aria-label="">
                    <ul class="pagination justify-content-end mb-0">
                    ' . $prev . '
                    ' . $pageCount . '
                    ' . $next . '
                    </ul>
                 </nav>
            </div>';
}

function paginationDefault($total, $page)
{

    $prev = "<a href=\"?page=" . ($page - 1) . "\"". (($page > 1 && $total > 1) ? "" : "class=\"disabled\"") ."><i class=\"fa fa-angle-left\"></i></a>";
    $next = "<a href=\"?page=" . ($page + 1) . "\"". (($page < $total && $total > 1) ? '' : "class=\"disabled\"") ."><i class=\"fa fa-angle-right\"></i></a>";
    
    $pageCount = "";

    $pageCount .= ($page - 2) > 1 ? '<a href="#">...</a>' : '';

    for ($i = ($page - 2) > 0 ? ($page - 2) : 1; $i <= (($page + 2) > $total ? $total : ($page + 2)); $i++) {
        if ($i == $page) {
            $pageCount .= '<a href="#" class="active">' . $i . '</a>';
        } else {
            $pageCount .= '<a href="?page=' . $i . '">' . $i . '</a>';
        }
    }

    $pageCount .= ($page + 2) < $total ? '<a href="#">...</a>' : '';
 
    return '<div class="col-lg-12 text-center">
    <div class="pagination__option">
    ' . $prev . '
    ' . $pageCount . '
    ' . $next . '
    </div>
</div>';
}


function handlPagination($limit, $page, $table)
{

    $count = DB::query("SELECT COUNT(id) as total FROM $table");

    $total_page = ceil($count[0]['total'] / $limit);

    if ($page > $total_page) {
        $page = $total_page;
    } else if ($page < 1) {
        $page = 1;
    }

    $start = ($page - 1) * $limit;
    return ['start' => $start, 'total' => $total_page];
}

function formatDate($date, $format = "d/m/Y")
{
    $date = date_create($date);
    return date_format($date, $format);
}

function slug($str, $table)
{
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);

    $get = DB::query("SELECT slug FROM $table WHERE slug = '$str'");
    if ($get) {
        $str .= '-' . randomString();
    }
    return $str;
}

function randomString($length = 4)
{
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randString = '';
    for ($i = 0; $i < $length; $i++) {
        $randString .= $characters[rand(0, strlen($characters))];
    }
    return $randString;
}

function sendMail($to, $toName, $title, $message)
{

    $mail = new MailSend(MAIL_CONFIG['server'], MAIL_CONFIG['port']);
    $mail->setProtocol(MailSend::TLS);
    $mail->setLogin(MAIL_CONFIG['username'], MAIL_CONFIG['password']);
    $mail->addTo($to, $toName);
    $mail->setFrom(MAIL_CONFIG['from'], MAIL_CONFIG['fromName']);
    $mail->setSubject($title);
    $mail->setHtmlMessage($message);
    if ($mail->send()) {
        return true;
    }
    return $mail->getLogs();
}
