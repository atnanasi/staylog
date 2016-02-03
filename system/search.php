$searchdir="./"
$searchname=$_GET["search"]

echo '<br><h1>',$searchname,'の検索結果</h1><br>';
if ($handle = opendir($searchdir)) {
   while (false !== ($file = readdir($handle))) {
      $fe = @fopen($searchdir.$file, "r" );
      $data = @fread($fe, filesize($searchdir.$file));
      if (stristr($data, $searchname)) {
         $spos = strpos($data, $searchname=$_GET["search"]);
         $epos = strpos($data, "<br>", $spos);
         if ($epos == ""){
            $epos = strlen($data);
         }
         $sname = substr($data, $spos, $epos);
         echo '<h2><a href=',$file,'>',$file,'</a></h2><h4><pre>',$sname,'</pre></h4>';
      }
   }
   closedir($handle);
}
