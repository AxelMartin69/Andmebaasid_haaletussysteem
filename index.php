<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Haletussusteem</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body class="">
        
        
        <?php
        date_default_timezone_set("Europe/Tallinn");
        include 'db.php';
        
        // define variables and set to empty values
        $nameErr = $decisionErr = "";
        $name = $decision = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $nameErr = "Name is required";
            } else {
                $name = test_input($_POST["name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    $nameErr = "Only letters and white space allowed";
                }
            }
          
            if (empty($_POST["decision"])) {
                $decisionErr = "Decision is required";
            } else {
                $decision = test_input($_POST["decision"]);
            }
        }
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
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

        if(array_key_exists('Submit', $_POST)) {
            update_data($name, $decision);
        };
        ?>
        
        <h2>Haaletussysteem</h2>
        <p><span class="error">* required field</span></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
            <label for='name'>Name:</label> 
            <input type="text" name="name" value="<?php echo $name;?>"> 
            <span class="error">* <?php echo $nameErr;?></span>
            <br><br>
            <label for='decision'>Decision:</label>
            <input type="radio" name="decision" <?php if (isset($decision) &&     $decision=="poolt") echo "checked";?> value="poolt">Poolt
            <input type="radio" name="decision" <?php if (isset($decision) &&     $decision=="vastu") echo "checked";?> value="vastu">Vastu
            <input type="radio" name="decision" <?php if (isset($decision) &&     $decision=="erapooletu") echo "checked";?> value="erapooletu">Erapooletu
            <span class="error">* <?php echo $decisionErr;?></span>
            <br><br>
            <input type="submit" name="submit" value="Submit">  
        </form>
        
        <?php
        
        update_data($name, $decision);
        result();
        voted_persons();
        
        ?>
    </body>
</html>