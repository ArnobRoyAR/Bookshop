<?php
$con = mysqli_connect("localhost", "root","", library);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql="SELECT id, book_name from books";
$result = $conn->query($sql);

if(result-> num_rows > 0){
    while($row = $result -> fetch_assoc()){
        echo "<tr><td>". $row["id"]. "</td><td>". $row["book_name"]."</td></tr>";
    }
    echo "</table>";
}
else{
    echo "0 result";
}
$con->close();
?>