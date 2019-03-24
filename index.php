<html>
 <head>
 <Title>Registration Form</Title>
 <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	
 </style>
 </head>
 <body>
 <div class="container" >
 <h1>Register here!</h1>
 <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
 <form method="post" action="index.php" class="form-group" enctype="multipart/form-data" >
 <div class="row">
 <div class="col-md-4">
       Name  <input type="text" class="form-control" name="name" id="name"/>
       </div>
       </div>
       <div class="row">
 <div class="col-md-4">
       Email <input type="text" class="form-control" name="email" id="email"/> 
       </div>
       </div>
       <div class="row">
 <div class="col-md-4">
       Job <input type="text" class="form-control" name="job" id="job"/> </div>
       </div>
       <br>
       <br>
       <div class="row">
      <div class="col-md-1">
       <input type="submit" class="btn btn-outline-success" name="submit" value="Submit" /> </div>
       <div class="col-md-1">
       <input type="reset" value="Reset" class="btn btn-outline-danger"></div>
       <div class="col-md-1">
       <input type="submit" name="load_data" class="btn btn-outline-primary" value="Load Data" /> </div>
</div>
 </form>
 </div>
 
    
 <?php
    $host = "aliffiawebappserver.database.windows.net";
    $user = "aliffia";
    $pass = "ita12345_";
    $db = "aliffiawebapp";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO Registration (name, email, job, date) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $job);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Registration";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo"<div class='container'></div><div class='row'> <div class='col-md-6'>";
                echo "<h2>People who are registered:</h2>";
                echo "<table class='table  table-hover '>";
                echo " <thead><tr class='table-primary'><th scope='col'>Name</th>";
                echo "<th scope='col'>Email</th>";
                echo "<th scope='col'>Job</th>";
                echo "<th scope='col'>Date</th></tr> </thead>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['job']."</td>";
                    echo "<td>".$registrant['date']."</td></tr></div>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
 </html>