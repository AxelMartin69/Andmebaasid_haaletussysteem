<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Haletussusteem</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->
    </head>
    <body>
        
        
        <?php
        // define variables and set to empty values
        $nameErr = $emailErr = $decisionErr = "";
        $name = $email = $decision = "";
        
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
        
        function update_data($name, $decision) {
            $servername = "193.40.62.9";
            $username = "tammekandaxelikt";
            $password = "PSdzxX55nMHx";
            $dbname = "tammekandaxelikt_haaletus";
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            
            $sql = "UPDATE HAALETUS SET otsus = '$decision' WHERE nimi = '$name'";
            
            if (mysqli_query($conn, $sql)) {
              echo "Record updated successfully";
            } else {
              echo "Error updating record: " . mysqli_error($conn);
            }
            
            $conn->close();
        }
        
        if(array_key_exists('Submit', $_POST)) {
            update_data($name, $decision);
        }
        
        ?>
        
        <h2>Haaletussysteem</h2>
        <p><span class="error">* required field</span></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
          Name: <input type="text" name="name" value="<?php echo $name;?>">
          <span class="error">* <?php echo $nameErr;?></span>
          <br><br>
          Decision:
          <input type="radio" name="decision" <?php if (isset($decision) && $decision=="poolt") echo "checked";?> value="poolt">Poolt
          <input type="radio" name="decision" <?php if (isset($decision) && $decision=="vastu") echo "checked";?> value="vastu">Vastu
          <span class="error">* <?php echo $decisionErr;?></span>
          <br><br>
          <input type="submit" name="submit" value="Submit">  
        </form>
        
        <?php
        echo "<h2>Sinu Andmed:</h2>";
        echo $name;
        echo "<br>";
        echo $email;
        echo "<br>";
        echo $decision;
        echo "<br>";
        
        update_data($name, $decision)
        
        
        ?>
    </body>
</html>