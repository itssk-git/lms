<style>
table{
   margin:10px 0px 10px
  }
  body{
    background-color:whitesmoke;
  }
 
  .container
  {
     display:flex;
     flex-direction:column;
     justify-content:space-between;
  }

  .d-flex 
  {
    margin:10px 0;
    
  }

  
  .d-flex a
  {
    
    color:#088178;
    font-weight: 700px;
    font-size:20px;
    text-decoration:none;
  }
  .d-flex a:hover
  {
    
    color:hsl(180, 70%, 35%);
    
  }
  tr{
    
    height:50px;
  }
 



  </style>

<?php include_once 'header.php'; ?>
<?php
include '../includes/connection.php';
?>

<?php
$sql = "SELECT m.name,f.amount,f.fine_date FROM fine f join
members m on m.member_id=f.member_id
";
$result = $conn->query($sql);

if ($result){


if ($result->num_rows > 0) {
    
    echo "<table class='table '>";
    echo "<tr>
            <th>S.N</th>
            <th>Member Name</th>
            <th>Fine Amount(paid)</th>
            <th>Date</th>
           
            
            
          </tr>";

    $sn=1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$sn."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['amount']."</td>";
        echo "<td>".$row['fine_date']."</td>";
        
       
        
        
        echo "</tr>";
        $sn++;
    }

    
    echo "</table>";
} else {
    echo "No fine history found.";
}
}



?>
</div>

    

    
</div>

</div>



<?php
include ('../includes/footer.php');

?>

