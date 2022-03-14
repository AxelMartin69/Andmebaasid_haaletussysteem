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
    exit();
}

function timer() {
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
    
    $sql = "SELECT h_alguse_aeg FROM tulemused /*WHERE otsus != 'haaletamata'*/";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<br>';
            echo $row['h_alguse_aeg'];
            echo '<br>';
            echo substr($row['h_alguse_aeg'], 14, 2);
            if(substr($row['h_alguse_aeg'], 14, 2)) {
                echo 'nii on';
            }
        }
    } else {
        echo "vittus";
    }
    

};

timer();
?>