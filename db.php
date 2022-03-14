<?php
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
        while($row = $result->fetch_assoc()) {
            echo $cnt.'. '.$row["nimi"].'------'.$row['otsus'];
            echo "<br>";
            $cnt++;
        }
    } else {
        echo "Keegi pole haaletanud";
    }
    
    $conn->close();
}

function update_data($name, $decision) {
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
    
    $sql = "UPDATE haaletus SET otsus = '$decision', aeg = CURRENT_TIMESTAMP() WHERE nimi = '$name'";
            
    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    
    $conn->close();
    echo "<br>";
    echo "<br>";
    voted_persons();
}

function timer() {
    
    // siia on jqueryt vaja
    // https://phpcoder.tech/how-to-display-current-running-clock-in-php/
            
            
    $min = 0;
    $sec = 55;
    echo '0:0 <br>';
    while ($min != 5) {
        $sec++;
        if ($sec <= 9) {
            $sec = 0 . $sec;
        } elseif ($sec == 60) {
            $sec = '00';
            $min++;
        };
        sleep(1);
        echo $min.':'.$sec.'<br>';
    };
};
?>