<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Database</title>
</head>
<body>
    <form action="DBclub.php" method="post">
       
       <?php
            $conn = new mysqli("localhost:3306", "root", "root", "football_league");
        ?>

        <?php
            if($_SERVER["REQUEST_METHOD"] === "POST")
            {

                // CREATE
                if($_REQUEST["knap"] == "create")
                {
                    $clubid = $_REQUEST["clubid"];
                    $name = $_REQUEST["name"];
                    $stadiumName = $_REQUEST["stadiumName"];
                    $sponsor = $_REQUEST["sponsor"];
                    $mascot = $_REQUEST["mascot"];
                    $picture = $_REQUEST["picture"];
                    if($name == "") $name = "ukendt";
                    if($stadiumName == "") $stadiumName = "ukendt";
                    if($sponsor == "") $sponsor = "ukendt";
                    if($mascot == "") $mascot = "ukendt";
                    if($picture == "") $picture = "ukendt";
                    if(is_numeric($clubid))
                    {
                        $sql = $conn->prepare("insert into club (id, name, stadium_name, sponsor, mascot, picture) values(?,?,?,?,?,?)");
                        $sql->bind_param("isssss", $clubid, $name, $stadiumName, $sponsor, $mascot, $picture);
                        $sql->execute();
                    }
                }

                // READ 
                if($_REQUEST["knap"] == "read")
                {
                    $clubid = $_REQUEST["clubid"];
                    if(is_numeric($clubid))
                    {
                        $sql = $conn->prepare("select * from club where id = ?");
                        $sql->bind_param("i", $clubid);
                        $sql->execute();
                        $result = $sql->get_result();
                        $row = $result->fetch_assoc();
                        $clubid = $row["id"];
                        $name = $row["name"];
                        $stadiumName = $row["stadium_name"];
                        $sponsor = $row["sponsor"];
                        $mascot = $row["mascot"];
                        $picture = $row["picture"];
                    }
                }

                // UPDATE
                if($_REQUEST["knap"] == "update")
                {
                    $clubid = $_REQUEST["clubid"];
                    $name = $_REQUEST["name"];
                    $stadiumName = $_REQUEST["stadiumName"];
                    $sponsor = $_REQUEST["sponsor"];
                    $mascot = $_REQUEST["mascot"];
                    $picture = $_REQUEST["picture"];
                    if($name == "") $name = "ukendt";
                    if($stadiumName == "") $stadiumName = "ukendt";
                    if($sponsor == "") $sponsor = "ukendt";
                    if($mascot == "") $mascot = "ukendt";
                    if($picture == "") $picture = "ukendt";
                    if(is_numeric($clubid))
                    {
                        $sql = $conn->prepare("update club set name = ?, stadium_name = ?, sponsor = ?, mascot = ?, picture = ? where id = ?");
                        $sql->bind_param("sssssi", $name, $stadiumName, $sponsor, $mascot, $picture, $clubid);
                        $sql->execute();
                    }
                }

                // DELETE
                if($_REQUEST["knap"] == "delete")
                {
                    $clubid = $_REQUEST["clubid"];
                    if(is_numeric($clubid))
                    {
                        $sql = $conn->prepare("delete from club where id = ?");
                        $sql->bind_param("i",$clubid);
                        $sql->execute();
                    }

                }

                // CLEAR 
                if($_REQUEST["knap"] == "clear")
                {
                    $clubid = "";
                    $name = "";
                    $stadiumName = "";
                    $sponsor = "";
                    $mascot = "";
                    $picture = "";
                }
            













            }

        ?>

        <?php
        $sql = "select * from club";
        $result = $conn->query($sql);

        echo "<table border='10' cellpadding='10'>";
        echo "<tr>";
        echo "<th>ClubID</th>";
        echo "<th>name</th>";
        echo "<th>stadium name</th>";
        echo "<th>sponsor</th>";
        echo "<th>mascot</th>";
        echo "<th>picture</th>";
        echo "</tr>";
        
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["stadium_name"] . "</td>";
                echo "<td>" . $row["sponsor"] . "</td>";
                echo "<td>" . $row["mascot"] . "</td>";
                echo "<td>" . "<img  src='" . $row['picture'] . "' alt='mascot' width='40%'>" . "</td>";
                echo "</tr>";
            }
        } 
        else
        {
            echo "No clubs";
        }
        
        echo "</table>";
        ?>

        <?php
            $conn->close();
        ?>

        <p>
            ClubID : <input type="text" name="clubid" value="<?php echo isset($clubid) ? $clubid :'' ?>" style="position: absolute; left: 120px; width: 100px; height: 22px"><br/><br/>
            Name : <input type="text" name="name" value="<?php echo isset($name) ? $name :'' ?>" style="position: absolute; left: 120px; width: 100px; height: 22px"><br/><br/>
            Stadium name : <input type="text" name="stadiumName" value="<?php echo isset($stadiumName) ? $stadiumName :'' ?>" style="position: absolute; left: 120px; width: 100px; height: 22px"><br/><br/>
            Sponsor : <input type="text" name="sponsor" value="<?php echo isset($sponsor) ? $sponsor :'' ?>" style="position: absolute; left: 120px; width: 100px; height: 22px"><br/><br/>
            Mascot : <input type="text" name="mascot" value="<?php echo isset($mascot) ? $mascot :'' ?>" style="position: absolute; left: 120px; width: 100px; height: 22px"><br/><br/>
            Picture : <input type="text" name="picture" value="<?php echo isset($picture) ? $picture :'' ?>" style="position: absolute; left: 120px; width: 100px; height: 22px"><br/><br/>
        </p>

    <p>
        <input type="submit" name="knap" value="create" style="width: 80px; margin-right: 1em; padding: 1em;">
        <input type="submit" name="knap" value="read" style="width: 80px; margin-right: 1em; padding: 1em;">
        <input type="submit" name="knap" value="update" style="width: 80px; margin-right: 1em; padding: 1em;">
        <input type="submit" name="knap" value="delete" style="width: 80px; margin-right: 1em; padding: 1em;">
        <input type="submit" name="knap" value="clear" style="width: 80px; margin-right: 1em; padding: 1em;">
    </p>
    </form>
</body>
</html>