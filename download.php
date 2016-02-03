<?php
//DlCounter

if (isset($_GET["next"]) and isset($_GET["file"])){
   $Redirect = $_GET["next"];
   $FileName = $_GET["file"];
}else{
   echo "アドレスが不正です。";
   exit;
}

$counter_file = "log/dlcounter/{$FileName}.log";
$counter_lenght = 8;

if (!file_exists($counter_file)) {
    touch($counter_file);
    chmod( $counter_file, 0666 );
    $ffp = fopen($counter_file, "r+");
    fwrite($ffp,  "0");
    fclose($ffp);
}

$fp = fopen($counter_file, "r+");

if ($fp){
    if (flock($fp, LOCK_EX)){

        $counter = fgets($fp, $counter_lenght);
        $counter++;

        rewind($fp);

        if (fwrite($fp,  $counter) === FALSE){
            echo "問題が発生しました。";
            exit;
        }

        flock($fp, LOCK_UN);
    }
}

fclose($fp);

header("Location: {$Redirect}");
exit;

?>
