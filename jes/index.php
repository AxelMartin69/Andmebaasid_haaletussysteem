<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Haletussusteem</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <style>
            body {
                padding: 1rem;
            }
        </style>
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
        
        if(array_key_exists('Submit', $_POST)) {
            update_data($name, $decision);
        };
        
        ?>
        
        <h2>Haaletussysteem</h2>
        <div class="row">    
            <form class="col s12">
                <div clas="row">
                    <div class="input-field col s6">
                        <input placeholder="Nimi" id="first_name" type="text" class="validate">
                        <label for="first_name">Nimi</label>
                    </div>
                    <div class="input-field col s6">
                        <p>
                            <label>
                                <input name="decision" type="radio" <?php if (isset($decision) &&       $decision=="poolt") echo "checked";?> value="poolt"/>
                                <span>Poolt</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="decision" type="radio" <?php if (isset($decision) &&       $decision=="vastu") echo "checked";?> value="vastu"/>
                                <span>Vastu</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="decision" type="radio" <?php if (isset($decision) &&       $decision=="erapooletu") echo "checked";?> value="erapooletu"/>
                                <span>Erapooletu</span>
                            </label>
                        </p>
                    </div>
                </div>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
        
        
        <?php
        update_data($name, $decision);
        voted_persons();
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    </body>
</html>