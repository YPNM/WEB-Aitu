<?php

$menu = array(
    '1' => array("name" => "Справки", "page" => "./"),
    '2' => array("name" => "Заявки", "page" => "./about"),
    '3' => array("name" => "Ошибки", "page" => "./contacts")
);

class load_page_vars {

    function title(){

        global $menu;
        $item = $menu;

        $str = '';
        $i=0;
        foreach($item as $k => $value)
        {
            $i++;
            if($item[$i]["page"] == ".".$this->state())
            {
                return $item[$i]["name"];
            }        
        }
    }

    function menu(){

        global $menu;

        $str = '';
        $i=0;
        foreach($menu as $k => $value)
        {
            $i++;
            $str.= "<li><a href='".$menu[$i]["page"]."' ".($menu[$i]["page"] == ".".$this->state() ? 'class="selected"' : '')." title='".$menu[$i]["name"]."'>".$menu[$i]["name"]."</a></li>";
        }
        //$this->state($page_title);
        return $str;
    }



    function content($page, $name){

        $post = array(
            'page' => ".".$page,
            'name' => $name,
            'password' => 'bar',
            'submit' => TRUE,
        );
         
        $data = http_build_query($post);

        $opts = array(
                  'http' => array(
                      'method' => 'POST',
                      'header' => "Content-type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($data) . "\r\n",
                      'content' => $data,
                  )
               );

        $context  = stream_context_create($opts);

        $url = $this->siteURL()."/content.php";
        $content = file_get_contents($url,FALSE,$context);

        return $content;
    }

    function state() {
        $request = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
        $str_repl = str_replace($request, '', $_SERVER['REQUEST_URI']);
        return $str_repl;
    }

    function siteURL()
    {
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $protocol = 'https://';
        }
        else {
          $protocol = 'http://';
        }

        $siteUrl = $protocol.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];

        return dirname($siteUrl);

    }

}

$data = new load_page_vars();



?>