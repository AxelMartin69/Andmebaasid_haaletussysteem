<?php
date_default_timezone_set("Europe/Tallinn");

function result() {
    echo "<br>";
    echo "<br>";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "haaletus";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT arv, h_alguse_aeg, poolt, vastu FROM tulemused;";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo 'Haaletanud: '.$row['arv'].'<br>Alguse aeg: '.$row['h_alguse_aeg'].'<br>Poolt: '.$row['poolt'].'<br>Vastu: '.$row['vastu'].'<br><br>';
        }
    }

    $conn->close();

}

function voted_persons() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "haaletus";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT nimi, otsus FROM haaletus /*WHERE otsus != 'haaletamata'*/";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        echo 'Haaletanud inimesed:<br><br>';
        $cnt = 1;
        echo '
            <table>
                <tr>
                    <th>Id</th>
                    <th>Nimi</th>
                    <th>Otsus</th>
                </tr>
            ';
        while($row = $result->fetch_assoc()) {
            echo '
                <tr>
                    <td>'.$cnt.'</td>
                    <td>'.$row["nimi"].'</td>
                    <td>'.$row['otsus'].'</td>
                </tr>
            ';      
            $cnt++;
        }
        echo '</table>';
    } else {
        echo "Keegi pole haaletanud";
    }
    
    $conn->close();
}

function update_data($name, $decision) {
    echo "<br>";
    echo "<br>";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "haaletus";
            
    $name = strtolower($name);
            
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $timer = "SELECT h_alguse_aeg FROM tulemused /*WHERE otsus != 'haaletamata'*/";
    $result = $conn->query($timer);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if(substr($row['h_alguse_aeg'], 0, 10) == date('Y-m-d') && substr($row['h_alguse_aeg'], 11, 2) == date('H') && substr($row['h_alguse_aeg'], 14, 2) <= date('i') && substr($row['h_alguse_aeg'], 14, 2) + 5 > date('i')) {
            } else {
                $update = "UPDATE haaletus SET otsus = 'haaletamata'";
                mysqli_query($conn, $update);
                die('Aeg on labi');
            }
            
        }
    }


    $sql = "UPDATE haaletus SET otsus = '$decision', aeg = CURRENT_TIMESTAMP() WHERE nimi = '$name'";
    $logi = "INSERT INTO logi(logi) VALUES ('$name:$decision')";
    mysqli_query($conn, $logi);
    if (mysqli_query($conn, $sql)) {
        echo "<h2>Sinu Andmed:</h2>";
        echo $name;
        echo "<br>";
        echo $decision;
        echo "<br><br><br>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    
    $conn->close();
    
};



?>