<?php

require_once __DIR__ . '/vendor/autoload.php';


$total_file_number = '';
if(isset($_POST['files'])){
    $total = $_POST['total']-1;
    for($i = 1; $i<=$total;$i++) {
        $file_pam = 'number'.$i;
        $file_pam_temp = $file_tmp =$_FILES[$file_pam]['tmp_name'];
        $html = file_get_contents($file_pam_temp);
        //echo $html;
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
         $domcss = $doc->getElementsByTagName('link');
        //var_dump($domcss);
        foreach($domcss as $links) {
            if( strtolower($links->getAttribute('rel')) == "stylesheet" ) {
                //echo "This is:". $links->getAttribute('href') ."<br />";
                $c_sslink = $links->getAttribute('href');
                echo file_get_contents($c_sslink);
                ?>
                <script>
                    append_css(<?php echo file_get_contents($c_sslink)?>);
                </script>
                <?php
                //echo $css;
            }
       }
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font_size' => 14]);
        $mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($html);
    }
       // $mpdf->Output('file/'.$file_pam.'.pdf', 'F');
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
if (!isset($_POST['num']) && !isset($_POST['files'])) {
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="intiger" name="number" placeholder="1">
        <input type="submit" name="num">
    </form>
    <?php
}
else if (!isset($_POST['files'])) {
    $total_file_number = $_POST['number'];
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

        <?php
        for($i = 1; $i<=$total_file_number;$i++) {
            ?>
            <input type="file" name="number<?php echo $i ?>" placeholder="this is <?php echo $i ?>">
            <br>
            <?php
        }
        ?>
        <input type="hidden" name="total" value="<?php echo $i ?>">
        <input type="submit" name="files">
    </form>
    <?php
}
?>
</body>
</html>
