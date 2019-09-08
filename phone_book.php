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
        $file = fopen($csv_name, 'r') or die("Unable to open file");
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

        
        // Extract columns
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
            echo "<tr onclick='displayPerson(event)' class='modal$line'>\n" .
                        "<td class='modal$line'>$fname[$line]</td>\n" .
                        "<td class='modal$line'>$lname[$line]</td>\n" .
                        "<td class='modal$line'>$phone[$line]</td>\n" .
                        "<td class='modal$line'>$st[$line]</td>\n" .
                        "<td class='modal$line'>$city[$line]</td>\n" .
                        "<td class='modal$line'>$zip[$line]</td>\n" .
                  "</tr>\n"
                  .
                  "<div id='modal$line' class='modal' style='display:none;'>\n" .
                        "<span class='modal$line' onclick='closeModal(event)'>&times;</span>" .
                        "<h2>$fname[$line] $lname[$line]</h2>\n" .
                        "<p>$phone[$line]</p>\n" . 
                        "<p>$st[$line] $zip[$line] $city[$line]</p>\n" .

                  "<div>";
        }
        echo "</table>\n";
        echo "<script>\n" . 
                "function displayPerson(event) {
                    let modal_id = event.target.className;
                    console.log(modal_id);
                    let modal = document.getElementById(modal_id);
                    modal.style.display = 'block';
                }\n" . 

                "function closeModal(event) {
                    let closeId = event.target.className;
                    console.log(closeId);
                    let modal = document.getElementById(closeId);
                    modal.style.display = 'none';
                }\n" .
             "</script>";   
       
        // Data for Summary footer
        echo "<footer>\n <h3>Summary</h3>\n";
        $city_count = array_count_values($city);
        foreach($city_count as $city => $count) {
            echo "<p><b>$city:</b> $count</p>\n";
        }
        echo "</footer>";

    ?>

 </body>
 </html>