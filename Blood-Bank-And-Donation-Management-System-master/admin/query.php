<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conn.php';
include 'session.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Query</title>

        <style>
<style>
    #sidebar {
        position: relative;
        margin-top: -20px;
    }

    #content {
        position: relative;
        margin-left: 210px;
    }

    @media screen and (max-width: 600px) {
        #content {
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }
    }

    .table-responsive .table {
        margin-bottom: 50px; /* Adjust as needed */
        background-color: #ff0000; /* Set background color */
        border: 1px solid #ffa500; /* Add border */
    }

    #he {
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 3px 7px;
        color: #fff;
        text-decoration: none;
        border-radius: 3px;
        align: center;
    }

    table {
        
        border-collapse: collapse; /* Collapse table borders */
        width: 80%; /* Ensure table takes full width */
    }

    th, td {
        padding: 10px; /* Adjust padding to add space */
        border: 1px solid black; /* Add border */
        text-align: left; /* Align text to left */
    }

    th {
        background-color: #f5f5f5; /* Header background color */
    }
</style>

        </style>
    </head>
    <body>

    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

 
                <h1 class="page-title"><center>User Query</center></h1>
    
        <hr>

        <?php
        $limit = 10;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM contact_query LIMIT $offset, $limit";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>
            
<table align="right">
                    <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Name</th>
                        <th>Email Id</th>
                        <th>Mobile Number</th>
                        <th>Message</th>
                        <th>Posting Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = $offset + 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['query_name']; ?></td>
                            <td><?php echo $row['query_mail']; ?></td>
                            <td><?php echo $row['query_number']; ?></td>
                            <td><?php echo $row['query_message']; ?></td>
                            <td><?php echo $row['query_date']; ?></td>
                            <td>
                            <td><?php echo $row['query_status'] == 1 ? 'Read' : '<a href="#" onclick="clickme(this, \'' . $row['query_id'] . '\')">Pending</a>';
?></td>


                            <td>
                                <a href="delete_query.php?id=<?php echo $row['query_id']; ?>" style="background-color: aqua;">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
              </div>
            

            <?php
            $total_records = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM contact_query"));
            $total_page = ceil($total_records / $limit);

            echo '<ul class="pagination admin-pagination">';
            if ($page > 1) {
                echo '<li><a href="query.php page='.($page - 1).'">Prev</a></li>';
            }
            for ($i = 1; $i <= $total_page; $i++) {
                $active = ($i == $page) ? 'active' : '';
                echo '<li class="'.$active.'"><a href="query.php?page='.$i.'">'.$i.'</a></li>';
            }
            if ($total_page > $page) {
                echo '<li><a href="query.php?page='.($page + 1).'">Next</a></li>';
            }
            echo '</ul>';
        } else {
            echo '<div class="alert alert-info">No records found.</div>';
        }
        ?>

    </div>

    <?php
} else {
    echo '<div class="alert alert-danger"><b>Please Login First To Access Admin Portal.</b></div>';
}
?>

</body>
</html>

<script>
  
        function clickme(element, query_id) {
    if (confirm("Do you really want to mark this query as Read?")) {
        element.innerHTML = "Read";

        // Send AJAX request to update_query_status.php
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "update_query_status.php?query_id=" + query_id, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText); // Log response
            }
        };
        xhr.send();
    }
}
</script>


<?php
mysqli_close($conn);
?>

