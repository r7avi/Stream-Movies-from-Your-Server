<?php
// dashboard.php

// Enable error reporting for this script
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Custom error handler function
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px;'>";
    echo "<strong>Error:</strong> [$errno] $errstr<br>";
    echo "Error on line $errline in file $errfile<br>";
    echo "</div>";
}

// Set custom error handler
set_error_handler("customErrorHandler");

// Include the header to maintain the structure
include 'header.php';

if (!isset($_SESSION['username'])) {
    // If the user is not authenticated, redirect to login
    header("Location: ../index.php");
    exit();
}

// Handle logout if the logout parameter is set in the URL
if (isset($_GET['logout'])) {
    // Destroy the session and redirect to login
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies and Series</title>
    <style>
        body {
            font-family: Jost, sans-serif;
            margin: 20px;
            font-weight: 600;
            font-size: 16px;
            overflow-x: hidden; /* Prevent horizontal overflow */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: middle; /* Align content vertically in the middle */
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
        }

        .back-link {
            text-align: right;
            margin-top: 20px;
            margin-right: 20px;
        }
        .icon {
            width: 30px;
            height: 30px;
            margin-right: 10px;
            vertical-align: middle; /* Align the icon vertically in the middle */
        }
        .moving-note {
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: red;
            animation: moveRightToLeft 15s linear infinite;
            white-space: nowrap;
        }

        @keyframes moveRightToLeft {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>
</head>
<body>
<?php

// Check if the 'name' session variable is set
if (isset($_SESSION['name'])) {
    // Display the user's name with red color and a smaller left margin
    echo '<div style="display: flex; justify-content: space-between; align-items: center;  margin-bottom: -20px; margin-left: 20px; margin-right: 20px;">';
    echo '<h4 style="color: red; text-align: left;">Hi, ' . $_SESSION['name'] . '</h4>';

    // Add a back link to navigate up one level if the 'dir' parameter is set and not equal to '.'
    if (isset($_GET['dir']) && $_GET['dir'] !== '.') {
        $parentDirectory = dirname($_GET['dir']);
        echo "<h4 class='back-link'><a href=\"?dir=" . urlencode($parentDirectory) . "\">Back</a></h4>";
    }

    echo '</div>';
}
?>

<?php

// Specify the directory you want to browse (e.g., 'drive')
$directory = 'drive';

// Check if a subdirectory is specified
if (isset($_GET['dir'])) {
    $subdirectory = urldecode($_GET['dir']);
    $subdirectoryPath = $directory . '/' . $subdirectory;

    // Check if the subdirectory exists
    if (is_dir($subdirectoryPath)) {
        $files = scandir($subdirectoryPath);

        // Check if scandir was successful
        if ($files !== false) {
            ?>
            <table>
                <tr>
                    <th>Name</th>
                    <?php
                    // Add the Action header only if the current directory is not the root directory
                    if (!empty($_GET['dir']) && !empty($files)) {
                        $showActionColumn = false;

                        // Check if there are any files in the current directory
                        foreach ($files as $file) {
                            if (!is_dir($subdirectoryPath . '/' . $file)) {
                                $showActionColumn = true;
                                break;
                            }
                        }

                        if ($showActionColumn) {
                            echo "<th>Action</th>";
                        }
                    }
                    ?>
                </tr>
                <?php
                foreach ($files as $key => $file) {
                    // Skip current and parent directory entries
                    if ($file === '.' || $file === '..') {
                        continue;
                    }

                    $filePath = $subdirectoryPath . '/' . $file;
                    $fileType = is_dir($filePath) ? 'Folder' : 'File';

                    echo "<tr>";
                    echo "<td><img class='icon' src='" . ($fileType === 'Folder' ? '../assets/folder.png' : '../assets/video.png') . "' alt='$fileType'>" .
                        "<a href=\"" . (is_dir($filePath) ? "?dir=" . urlencode($subdirectory . '/' . $file) : ($fileType === 'File' ? "play.php?dir=" . urlencode($subdirectory) . "&file=$key" : $filePath)) . "\">" . pathinfo($file, PATHINFO_FILENAME) . "</a></td>";

                    // Display the Action column only for files, not for folders
                    if ($fileType === 'File' && !empty($_GET['dir'])) {
                        echo "<td>";

                        // Action for files
                        if (in_array(pathinfo($file, PATHINFO_EXTENSION), array('mp4', 'mkv'))) {
                            echo "<a href=\"play.php?dir=" . urlencode($subdirectory) . "&file=$key\">Play</a>";
                        }

                        echo "</td>";
                    }

                    echo "</tr>";
                }
                ?>
            </table>
            <?php
        } else {
            echo "Failed to read the contents of the directory.";
        }
    } else {
        echo "Subdirectory not found.";
    }
} else {
    // If no subdirectory is specified, show the contents of the root directory
    $files = scandir($directory);
    ?>
    <table>
        <tr>
            <th>Name</th>
            <?php
            // Add the Action header only if there are files in the root directory
            if (!empty($files)) {
                $showActionColumn = false;

                // Check if there are any files in the root directory
                foreach ($files as $file) {
                    if (!is_dir($directory . '/' . $file)) {
                        $showActionColumn = true;
                        break;
                    }
                }

                if ($showActionColumn) {
                    echo "<th>Action</th>";
                }
            }
            ?>
        </tr>
        <?php
        foreach ($files as $key => $file) {
            // Skip current and parent directory entries
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $directory . '/' . $file;
            $fileType = is_dir($filePath) ? 'Folder' : 'File';

            echo "<tr>";
            echo "<td><img class='icon' src='" . ($fileType === 'Folder' ? '../assets/folder.png' : '../assets/video.png') . "' alt='$fileType'>" .
                "<a href=\"" . (is_dir($filePath) ? "?dir=" . urlencode($file) : ($fileType === 'File' ? "play.php?dir=" . urlencode($directory) . "&file=$key" : $filePath)) . "\">$file</a></td>";

            // Display the Action column only for files, not for folders
            if ($fileType === 'File') {
                echo "<td>";

                // Action for files
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), array('mp4', 'mkv'))) {
                    echo "<a href=\"play.php?dir=" . urlencode($directory) . "&file=$key\">Play</a>";
                }

                echo "</td>";
            }

            echo "</tr>";
        }
        ?>
    </table>
    <?php
}
?>

<div style="text-align: center; margin-top: 20px; margin-right: 20px;">
    <a href="../public/request.php" style="color: #6C22A6;">&#8594; <u>Request Movies (or) Series</u> &#8592;</a>
    <br><br>
    <div class="moving-note">* Fixed Back Link <br>* Registrations are Enabled.</div>
</div>
</body>
</html>

<?php include 'footer.php'; ?>
