<?php
// log.php
include 'config/db.php';

// Set the number of records to display per page
$recordsPerPage = 20;

// Determine the current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $recordsPerPage;

// Fetch records for the current page
$loginHistoryQuery = "SELECT id, username, login_time FROM login_history ORDER BY login_time DESC LIMIT $recordsPerPage OFFSET $offset";
$result = $conn->query($loginHistoryQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
           
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: 1px solid #ddd;
            margin-right: 200px;
            float: right;
            margin-top: -10px;
        }
        .centered-div {
            text-align: center;
            padding: 20px;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            text-decoration: none;
            color: #4CAF50;
            border: 1px solid #ddd;
            margin: 0 4px;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .pagination .active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

    <div class="centered-div">
        <h2>Login History</h2>
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Login Time</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['username']}</td>";
                        
                        // Convert database time to DateTime object
                        $loginTime = new DateTime($row['login_time'], new DateTimeZone('UTC'));
                        $loginTime->setTimezone(new DateTimeZone('Asia/Kolkata')); // Adjust to your desired timezone
                        
                        echo "<td>" . $loginTime->format('Y-m-d h:i A') . "</td>";
                        echo "<td><input type='checkbox' class='logCheckbox' value='{$row['id']}'></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
        </table>

        <!-- Pagination links -->
        <div class="pagination">
            <?php
            $totalRecordsQuery = "SELECT COUNT(*) AS total FROM login_history";
            $totalRecordsResult = $conn->query($totalRecordsQuery);
            $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
            $totalPages = ceil($totalRecords / $recordsPerPage);

            for ($i = 1; $i <= $totalPages; $i++) {
                $class = ($i == $page) ? "active" : "";
                echo "<a class='$class' href='?page=$i'>$i</a>";
            }
            ?>
            <button onclick="deleteSelectedLogs()">Delete Selected</button>
        </div>
        
    </div>

    <script>
        function deleteSelectedLogs() {
            const checkboxes = document.querySelectorAll('.logCheckbox:checked');
            const logIds = Array.from(checkboxes).map(checkbox => checkbox.value);

            if (logIds.length > 0) {
                if (confirm('Are you sure you want to delete the selected logs?')) {
                    window.location.href = `config/delete_logs.php?logIds=${logIds.join(',')}`;
                }
            } else {
                alert('Please select logs to delete.');
            }
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>
