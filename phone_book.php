 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Phone Book</title>
</head>
<body>
    <?php
        $csv_name = $_GET["csv"];
        $file = fopen($csv_name, 'r');
        $data = array();
        $col_names = fgetcsv($file);
        $col_length = count($col_names);
        $row = 0;

        while (!feof($file)) {
            $line = fgetcsv($file);
            if (!$line) {
                continue;
            }
            for ($col = 0; $col < $col_length; $col++) {
                $data[$row][$col_names[$col]] = $line[$col];
            }
            $row++;
        }

        
        $fname = array_column($data, "fname");
        $lname = array_column($data, "lname");
        $phone = array_column($data, "phone");
        $st = array_column($data, "st");
        $city = array_column($data, "city");
        $zip = array_column($data, "zip");
       
        array_multisort($lname, $fname, $phone, $st, $city, $zip);

        $data_size = count($data);

        echo "<table> \n";
        foreach ($col_names as $value) {
            echo "<th>$value</th>\n";
        }
        for ($line = 0; $line < $data_size; $line++) {
            echo "<tr>\n" .
                        "<td>$fname[$line]</td>\n" .
                        "<td>$lname[$line]</td>\n" .
                        "<td>$phone[$line]</td>\n" .
                        "<td>$st[$line]</td>\n" .
                        "<td>$city[$line]</td>\n" .
                        "<td>$zip[$line]</td>\n" .
                  "</tr>\n";
        }
        echo "</table>";
       

    ?>

 </body>
 </html>