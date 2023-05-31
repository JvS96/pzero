<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<?php
$html = file_get_contents('https://www.worldometers.info/coronavirus/');

$dom = new DOMDocument();
libxml_use_internal_errors(true); // Disable libxml errors

// Load HTML from string
$dom->loadHTML($html);

libxml_use_internal_errors(false); // Enable libxml errors

$table = $dom->getElementById('main_table_countries_today'); // Get the table element

$data = array();

// Iterate through table rows
foreach ($table->getElementsByTagName('tr') as $row) {
        $rowData = array();

        // Iterate through table cells
        foreach ($row->getElementsByTagName('td') as $cell) {
            $rowData[] = $cell->nodeValue;
        }

        $data[] = $rowData;
    }

$jsonString = json_encode($data);

$decodedData = json_decode($jsonString, true);

?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
        <table class="table table-striped">
            <tr>
                <th>Country</th>
                <th>Total Cases</th>
                <th>New Cases</th>
                <th>Total Deaths</th>
                <th>New Deaths</th>
                <th>Total Recovered</th>
            </tr>
            <?php foreach ($decodedData as $value){ ?>
                <tr>
                    <td><?php echo isset($value['1']) ? $value['1'] : ""; ?></td>
                    <td><?php echo isset($value['2']) ? $value['2'] : ""; ?></td>
                    <td><?php echo isset($value['3']) ? $value['3'] : ""; ?></td>
                    <td><?php echo isset($value['4']) ? $value['4'] : ""; ?></td>
                    <td><?php echo isset($value['5']) ? $value['5'] : ""; ?></td>
                    <td><?php echo isset($value['6']) ? $value['6'] : ""; ?></td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>
