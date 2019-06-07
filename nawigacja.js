<!DOCTYPE html>
<html lang ="pl">
<head>
<title>Menu rozwijane pionowe - demo</title>
<style type="text/css">
* {margin: 0; padding: 0;}
#menu li {list-style: none;}
#menu, #menu ul {width: 160px;}
#menu ul {visibility: hidden; position: absolute; top: 0; left: 100%; padding-left: 1px;}
#menu li {padding-bottom: 1px; line-height: 0; position: relative;}
#menu li:hover ul {visibility: visible;}
#menu a, #menu li:hover li a {display: block; font: 12px/30px verdana, sans-serif; text-decoration: none; padding: 0 10px; width: 140px; color: #fff; background-color: #666;}
#menu li:hover a, #menu li:hover li:hover a {background-color: #333095;}

/*/ xerif hack: /*/
#menu li:hover ul{left: 100%; opacity: 1; transition-delay: 0s; -webkit-transition-delay: 0s; -moz-transition-delay: 0s;}
#menu li ul{left: 0; visibility: visible; opacity: 0; transition: all 1s 1s; -webkit-transition: all 1s 1s; -moz-transition: all 1s 1s;}
/**/
</style>
</head>
<body>
<ul id="menu">
  <li><a href="#">Link 1</a>
    <ul>
      <li><a href="#">Link 1.1</a></li>
      <li><a href="#">Link 1.2</a></li>
      <li><a href="#">Link 1.3</a></li>
    </ul>
  </li>
  <li><a href="#">Link 2</a>
    <ul>
      <li><a href="#">Link 2.1</a></li>
      <li><a href="#">Link 2.2</a></li>
      <li><a href="#">Link 2.3</a></li>
    </ul>
  </li>
  <li><a href="#">Link 3</a>
    <ul>
      <li><a href="#">Link 3.1</a></li>
      <li><a href="#">Link 3.2</a></li>
      <li><a href="#">Link 3.3</a></li>
    </ul>
  </li>
</ul>
</body>
</html>

lub

<?php
function parseNodes($nodes) {
        $ul = "<ul>\n";
        foreach ($nodes as $node) {
                $ul .= parseNode($node);
        }
        $ul .= "</ul>\n";
        return $ul;
}

function parseNode($node) {
        $li = "\t<li>";
        $li .= '<a href="'.$node->url.'">'.$node->title.'</a>';
        if (isset($node->nodes)) $li .= parseNodes($node->nodes);
        $li .= "</li>\n";
        return $li;
}


$json = '[{
"title":"About",
"url":"/about",
"nodes":[
    {"title":"Staff","url":"/about/staff"},
    {"title":"Location","url":"/about/location"}
]},{
"title":"Contact",
"url":"/contact"
}]';
$nodes = json_decode($json);

$html = parseNodes($nodes);
echo $html;

wyciete z pliku strona 1:
$conn = mysqli_connect("localhost", "root", "");  
        $sql = "SELECT ID, user, email from ID_Pracownicy";
        $result = $conn-> query($sql);
        if ($result-> num_rows > 0) {
        while ($row = $result-> fetch_assoc()) {
        echo "<tr><td>". $row["ID"] . "</td><td>". $row["user"] ."</td><td>". $row["email"] ."</td></tr>";