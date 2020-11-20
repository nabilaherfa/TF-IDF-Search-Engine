<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Search Result</title>
        <link rel="stylesheet" href="hasil.css">
    </head>
    <body>
        <div class="result">
            <?php
            require_once 'vendor/autoload.php';
            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();
            $stopwordFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
            $stopword = $stopwordFactory->createStopWordRemover();

            if(isset($_POST['query'])) {
                $query=$_POST['query'];

            $fp = fopen("query.txt", 'w');
            fwrite($fp, $query);
            fclose($fp);
            }
            function sim ($hasilQueryFieldKataKunci1){
                $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
                $stemmer  = $stemmerFactory->createStemmer();
                $stopwordFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
                $stopword = $stopwordFactory->createStopWordRemover();

                $frequency= array();
                $hasilQueryFieldKataKunci = file_get_contents("query.txt");
                $hasilQueryFieldKataKunci = $stopword->remove($stemmer->stem($hasilQueryFieldKataKunci));
                $arrayOfKataKunci = explode(" ", $hasilQueryFieldKataKunci);
                foreach ($arrayOfKataKunci as $kataKunci) {
                    if ( ! array_key_exists($kataKunci, $frequency)) {
                        $frequency[$kataKunci] = 1;
                    }else {
                        $frequency[$kataKunci] = $frequency[$kataKunci] + 1;
                    }
                }
                $frequency1=array();
                $hasilQueryFieldKataKunci1 = $stopword->remove($stemmer->stem($hasilQueryFieldKataKunci1));
                $arrayOfKataKunci1 = explode(" ", $hasilQueryFieldKataKunci1);

                foreach ($arrayOfKataKunci1 as $kataKunci1) {
                    if ( ! array_key_exists($kataKunci1, $frequency1)) {
                        $frequency1[$kataKunci1] = 1;
                    }else {
                        $frequency1[$kataKunci1] = $frequency1[$kataKunci1] + 1;
                    }
                }
                $hit = 0;
                $arrayOfKataKunci = array_unique($arrayOfKataKunci);
                $arrayOfKataKunci1 = array_unique($arrayOfKataKunci1);
                foreach($arrayOfKataKunci as $val){
                    foreach($arrayOfKataKunci1 as $val1){
                        if($val==$val1){
                            $hit+=($frequency[$val]*$frequency1[$val1]);
                        }
                    }
                }
                $hitung = 0;
                foreach($arrayOfKataKunci as $val){
                    $hitung = $hitung + $frequency[$val]*$frequency[$val];
                }
                $hitung = sqrt($hitung);
                $hitung1 = 0;
                foreach($arrayOfKataKunci1 as $val1){
                    $hitung1 = $hitung1 + $frequency1[$val1]*$frequency1[$val1];
                }
                $hitung1 = sqrt($hitung1);
                return floatval($hit/($hitung*$hitung1));
            }
            function bubble_Sort(array $my_array, array $namafile)
            {
                do
                {
                    $swapped = false;
                    for( $i = 0, $c = count( $my_array ) - 1; $i < $c; $i++ )
                    {
                        if( $my_array[$i] < $my_array[$i + 1] )
                        {
                            list( $my_array[$i + 1], $my_array[$i] ) = array( $my_array[$i], $my_array[$i + 1] );
                            list( $namafile[$i + 1], $namafile[$i] ) = array( $namafile[$i], $namafile[$i + 1] );
                            $swapped = true;
                        }
                    }
                }
                while( $swapped );
            return $namafile;
            }
            function jmlkata ($a){
                $arrayOfKataKunci1 = explode(" ", $a);
                return count($arrayOfKataKunci1);
            }
            $dokumen = "dokumen/";
            if(!($buka_folder = opendir($dokumen))) die ("Error Brow!");

            $file_array = array();
            while($baca_folder = readdir($buka_folder))
            {
                if(substr($baca_folder,0,1) != '.')
                {
                    $file_array[] =  $baca_folder;
                }
            }

            $rank = array();
            set_include_path('./dokumen');
            for($i=0; $i<count($file_array); $i++){
                $rank[$i]=sim(file_get_contents ($file_array[$i],FILE_USE_INCLUDE_PATH));
            }

            $ranked=bubble_Sort($rank, $file_array);
            rsort($rank);

            echo "<div id=\"intro\">Hasil Pencarian: (diurutkan dari tingkat kemiripan tertinggi)";
            echo "<br><br>";
            echo "</div>";

            while(list($index, $namafile) = each($ranked))
            {
                echo "<div id=\"rank\">";
                $nomor = $index + 1;
                echo "$nomor. <a href='dokumen/$namafile'>$namafile</a>";
                echo "<br>";
                echo "</div>";
                $a=file_get_contents($namafile,FILE_USE_INCLUDE_PATH);
                $c=jmlkata($a);
                echo "<div id=\"detail\">";
                echo "Jumlah Kata: $c";
                echo "<br>";
                $mirip=$rank[$index]*100;
                echo "Tingkat kemiripan: $mirip %";
                echo "<br>";
                $pecah=explode(".",$a);
                echo $pecah[0];
                echo "<br><br>";
                echo "</div>";
            }
            closedir($buka_folder);

            function tabel ($hasilQueryFieldKataKunci1) {
                $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
                $stemmer  = $stemmerFactory->createStemmer();
                $stopwordFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
                $stopword = $stopwordFactory->createStopWordRemover();
            
                // Pengeluaran term
                $frequency= array();
                $hasilQueryFieldKataKunci = file_get_contents("query.txt");
                $hasilQueryFieldKataKunci = $stopword->remove($stemmer->stem($hasilQueryFieldKataKunci));
                $arrayOfKataKunci = explode(" ", $hasilQueryFieldKataKunci);
                foreach ($arrayOfKataKunci as $kataKunci) {
                    if ( ! array_key_exists($kataKunci, $frequency)) {
                        $frequency[$kataKunci] = 1;
                    } else {
                        $frequency[$kataKunci] = $frequency[$kataKunci] + 1;
                    }
                }
            
                $query1 = array_unique($arrayOfKataKunci);
                $hasilQueryFieldKataKunci1 = $stopword->remove($stemmer->stem($hasilQueryFieldKataKunci1));
                $arrayOfKataKunci1 = explode(" ", $hasilQueryFieldKataKunci1);
                $frequency1=array();
                foreach ($query1 as $kataKunci) {
                    $frequency1[$kataKunci] = 0;
                    foreach($arrayOfKataKunci1 as $kataKunci1){
                        if($kataKunci1==$kataKunci){
                            $frequency1[$kataKunci]++;
                        } 
                    }
                }
                return $frequency1;
            }

            $frequency= array();
            $hasilQueryFieldKataKunci = file_get_contents("query.txt");
            $hasilQueryFieldKataKunci = $stopword->remove($stemmer->stem($hasilQueryFieldKataKunci));
            $arrayOfKataKunci = explode(" ", $hasilQueryFieldKataKunci);
            foreach ($arrayOfKataKunci as $kataKunci) {
                if ( ! array_key_exists($kataKunci, $frequency)) {
                    $frequency[$kataKunci] = 1;
                } else {
                    $frequency[$kataKunci] = $frequency[$kataKunci] + 1;
                }
            }
                
            $result = $frequency;
            for($i=0; $i<count($file_array); $i++){
                $docs=tabel(file_get_contents ($file_array[$i],FILE_USE_INCLUDE_PATH));
                $result = array_merge_recursive($result,$docs);
            }
            
            echo "<div id=\"tabel\">";
            echo "<table border='1'>\n";
            echo "<tr><th>Term</th><th>Query</th>";
            for($i=0; $i<count($file_array); $i++){
                echo "<th>" . $file_array[$i] . "</th>";
            }
            echo "</tr>\n";

            foreach ($result as $key => $row) {
                echo "<tr><td>" . $key . "</td>";
                foreach ($row as $key2 => $val) {
                echo "<td>" . $result[$key][$key2] . "</td>";
                }
                echo "</tr>\n";
            }
            echo "</table>\n";
            echo "</div>"

            ?>
        </div>
    </body>
</html>