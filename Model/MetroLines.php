<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startingLine = $_POST['starting_line'];
    $destinationLine = $_POST['destination_line'];
    $startingStation = $_POST['starting_station'];
    $finalStation = $_POST['final_station'];
}
class MetroLines {
    public static $lines = [
        1 => [ // Line 1
            "Helwan", "Ain Helwan", "Helwan University", "Wadi Hof", "Hadayek Helwan", "El-Maasara", "Tora El-Asmant", "Kozzika", "Tora El-Balad", "Sakanat El-Maadi", "Maadi", "Hadayek El-Maadi", "Dar El-Salam", "El-Zahraa'", "Mar Girgis", "El-Malek El-Saleh", "Al-Sayeda Zeinab", "Saad Zaghloul", "Sadat", "Nasser", "Orabi", "Al-Shohadaa", "Ghamra", "El-Demerdash", "Manshiet El-Sadr", "Kobri El-Qobba", "Hammamat El-Qobba", "Saray El-Qobba", "Hadayeq El-Zaitoun", "Helmeyet El-Zaitoun", "El-Matareyya", "Ain Shams", "Ezbet El-Nakhl", "El-Marg", "New El-Marg"
        ],
        2 => [ // Line 2
            "Shubra El-Kheima", "Kolleyyet El-Zeraa", "Mezallat", "Khalafawy", "St. Teresa", "Road El-Farag", "Masarra", "Al-Shohadaa", "Attaba", "Mohamed Naguib", "Sadat", "Opera", "Dokki", "El Bohoth", "Cairo University", "Faisal", "Giza", "Omm El-Masryeen", "Sakiat Mekky", "El-Mounib"
        ],
        3 => [ // Line 3
            "Rod El Farag Corridor", "Ring Road", "El-Qawmia", "El-Bohy", "Imbaba", "Sudan", "Kit Kat","Safaa Hegazy", "Maspero", "Nasser", "Attaba", "Eastern Section", "Bab El Shaariya", "El-Geish", "Abdou Pasha", "Abbassiya", "Stadium", "Koleyet El-Banat", "Al-Ahram", "Haroun", "Heliopolis", "Al-Hegaz", "Military Academy", "Sheraton", "Airport", "Alf Maskan", "El Shams Club", "El Nozha", "Hesham Barakat", "Qubaa", "Omar Ibn El Khattab", "Haykestep", "Adly Mansour"
        ]
    ];

    public static function getStationsCount($line, $startStation, $endStation) {
        $stations = self::$lines[$line];
        $startIndex = array_search($startStation, $stations);
        $endIndex = array_search($endStation, $stations);
        if ($startIndex === false || $endIndex === false) {
            return null; // Station not found
        }
        return abs($endIndex - $startIndex) +1; 
    }

    public static function getStationsCountWithSwitch($startLine, $startStation, $endLine, $endStation) {
        // List of interchange stations
        $interchanges = [
            ["Al-Shohadaa", 1, 2],
            ["Sadat", 1, 2],
            ["Attaba", 2, 3],
            ["Nasser", 1, 3]
        ];

        // If on the same line, use the normal function
        if ($startLine == $endLine) {
            return self::getStationsCount($startLine, $startStation, $endStation, $endLine);
        }

        // Try all interchanges between the two lines
        foreach ($interchanges as $interchange) {
            list($station, $lineA, $lineB) = $interchange;
            if (
                ($startLine == $lineA && $endLine == $lineB) ||
                ($startLine == $lineB && $endLine == $lineA)
            ) {
                // Calculate stations from start to interchange on startLine
                $count1 = self::getStationsCount($startLine, $startStation, $station, $startLine);
                // Calculate stations from interchange to end on endLine
                $count2 = self::getStationsCount($endLine, $station, $endStation, $endLine);
                if ($count1 !== null && $count2 !== null) {
                    // Subtract 1 to avoid double-counting the interchange station
                    return $count1 + $count2 - 1;
                }
            }
        }
        // If no valid interchange found
        return null;
    }
}
?>