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

// Remove the first empty row
array_shift($data);

// Prepare the table HTML
$tableHTML = '<table>';
    $tableHTML .= '<thead>
                        <tr>
                            <th>Country</th>
                            <th>Total Cases</th>
                            <th>New Cases</th>
                            <th>Total Deaths</th>
                            <th>New Deaths</th>
                            <th>Total Recovered</th>
                        </tr>
                    </thead>';
    $tableHTML .= '<tbody>';

    // Iterate through the data and generate table rows
    foreach ($data as $row) {
    $tableHTML .= '<tr>';
        $tableHTML .= '<td>' . $row[1] . '</td>';
        $tableHTML .= '<td>' . $row[2] . '</td>';
        $tableHTML .= '<td>' . $row[3] . '</td>';
        $tableHTML .= '<td>' . $row[4] . '</td>';
        $tableHTML .= '<td>' . $row[5] . '</td>';
        $tableHTML .= '<td>' . $row[6] . '</td>';
        $tableHTML .= '</tr>';
    }

    $tableHTML .= '</tbody>';
    $tableHTML .= '</table>';

echo $tableHTML;