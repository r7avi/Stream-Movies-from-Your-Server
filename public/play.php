<?php
// Include the header to maintain the structure
include 'header.php';



// Check if the user is authenticated
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

$directory = '../public/drive'; // specify the directory you want to browse

if (isset($_GET['dir']) && isset($_GET['file'])) {
    $subdirectory = urldecode($_GET['dir']);
    $fileIndex = (int)$_GET['file'];

    $subdirectoryPath = $directory . '/' . $subdirectory;
    $files = scandir($subdirectoryPath);

    // Check if the file index is within bounds
    if ($fileIndex >= 0 && $fileIndex < count($files)) {
        $filePath = $subdirectoryPath . '/' . $files[$fileIndex];
        $fileName = pathinfo($files[$fileIndex], PATHINFO_FILENAME);

        // Use FFmpeg to extract a thumbnail dynamically for the video player
        ob_start();
        passthru("ffmpeg -i \"$filePath\" -ss 00:00:05 -vframes 1 -f image2pipe -vcodec png -");
        $videoThumbnailData = ob_get_clean();

        // Display video player or redirect to the next/previous file
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="robots" content="noindex, nofollow">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= htmlspecialchars($fileName) ?></title>
            <!-- Add your styles here -->

            <!-- Plyr CSS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">

<!-- Plyr JS -->
<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
            <style>
                    <style>
                body {
              
                    transition: background-color 0.5s ease; /* Added transition for smooth effect */
                }

                .dark-mode {
                    background-color: black; /* Change background color for dark mode */
                    color: white; /* Change text color for dark mode */
                }

                .disco-mode {
                    animation: disco 1s infinite;
                }

                @keyframes disco {
    0% { background-color: red; color: white; }
    5% { background-color: orange; color: black; }
    10% { background-color: yellow; color: black; }
    15% { background-color: green; color: white; }
    20% { background-color: blue; color: white; }
    25% { background-color: purple; color: white; }
    30% { background-color: pink; color: black; }
    35% { background-color: cyan; color: black; }
    40% { background-color: magenta; color: white; }
    45% { background-color: lime; color: black; }
    50% { background-color: red; color: white; }
    55% { background-color: gold; color: black; }
    60% { background-color: indigo; color: white; }
    65% { background-color: brown; color: white; }
    70% { background-color: turquoise; color: black; }
    75% { background-color: darkslategray; color: white; }
    80% { background-color: hotpink; color: black; }
    85% { background-color: lavender; color: black; }
    90% { background-color: olive; color: white; }
    95% { background-color: rosybrown; color: white; }
    100% { background-color: red; color: white; }
}


                

                p {
                    margin-bottom: 20px;
                }

                .thumbnails-container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                }

                .thumbnail-item {
                    margin: 10px;
                    text-align: center;
                    width: 45%; /* Two items in a row on larger screens */
                }

                .thumbnail-item img {
                    width: 100%;
                    height: auto;
                }

                @media (max-width: 768px) {
                    .thumbnail-item {
                        width: 100%; /* One item per row on smaller screens */
                    }
                }
            </style>
        </head>
        <body>

        <!-- Display the video player with the generated thumbnail as the preview image -->
        <div style="text-align: center; margin-bottom: 20px;">
            <h2><?= htmlspecialchars($fileName) ?></h2>
            <?php if (!empty($videoThumbnailData)): ?>
                <video id="myVideo" width="100%" height="100%" controls style="margin-top: 10px;" poster="data:image/png;base64,<?= base64_encode($videoThumbnailData) ?>">
    <source src="<?= $filePath ?>" type="video/mp4">
    Your browser does not support the video tag.
</video>
            <?php else: ?>
                <p>No Thumbnail Available</p>
            <?php endif; ?>
            <div><br>            
        </p><a href="javascript:void(0);" id="toggle-light">Screen Light On/Off</a>
                <br><br><a href="javascript:void(0);" id="toggle-disco"><u><h2>--->  Party Mode  &#128539;  <---</h2></u></a>
            </div>
        </div>

<div style="display: flex; flex-wrap: wrap; justify-content: center;">
    <p>
        <?php if ($fileIndex > 0 && count($files) > 1 && !empty($files[$fileIndex - 1])): ?>
            <a href="play.php?dir=<?= urlencode($subdirectory) ?>&file=<?= $fileIndex - 1 ?>"><u>Previous</u></a> |
        <?php endif; ?>
        <?php if ($fileIndex < count($files) - 1): ?>
            <a href="play.php?dir=<?= urlencode($subdirectory) ?>&file=<?= $fileIndex + 1 ?>"><u>Next</u></a> |
        <?php endif; ?>
        <?php if ($fileIndex > 0 || $fileIndex < count($files) - 1): ?>
            <a href="../index.php"><u>Home</u></a>
        <?php endif; ?>
    </p>
</div>

<div style="display: flex; flex-wrap: wrap; justify-content: center;">
    <h3 style="color: red;"><?php if ($fileIndex < count($files) - 1): ?>Upcoming videos<?php endif; ?></h3>
</div>

<div style="display: flex; flex-wrap: wrap; justify-content: center;">
    <?php
    // Display the next three videos
    $videosToShow = min(4, count($files) - $fileIndex - 1);
    for ($i = $fileIndex + 1; $i <= $fileIndex + $videosToShow; $i++) {
        $nextFilePath = $subdirectoryPath . '/' . $files[$i];

        // Check if the file is a video (you can add more video extensions as needed)
        if (pathinfo($files[$i], PATHINFO_EXTENSION) === 'mp4') {
            // Use FFmpeg to extract a thumbnail dynamically
            ob_start();
            passthru("ffmpeg -i \"$nextFilePath\" -ss 00:00:05 -vframes 1 -f image2pipe -vcodec png -");
            $thumbnailData = ob_get_clean();

            // Display the file name and thumbnail
            ?>
            <div style="margin: 10px; text-align: center; max-width: 200px;">
                <a href="play.php?dir=<?= urlencode($subdirectory) ?>&file=<?= $i ?>">
                    <?php if (!empty($thumbnailData)): ?>
                        <img src="data:image/png;base64,<?= base64_encode($thumbnailData) ?>" alt="Thumbnail" style="width: 100%; height: auto;">
                    <?php else: ?>
                        <p>No Thumbnail Available</p>
                    <?php endif; ?>
                </a>
                <p><?= htmlspecialchars(pathinfo($files[$i], PATHINFO_FILENAME)) ?></p>
            </div>
            <?php
        }
    }
    ?>
</div>
        <script>
            // JavaScript for toggling light/dark mode
            document.getElementById('toggle-light').addEventListener('click', function () {
                document.body.classList.toggle('dark-mode');
            });

             // JavaScript for disco mode
             document.getElementById('toggle-disco').addEventListener('click', function () {
                document.body.classList.toggle('disco-mode');
            });
        </script>

<script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const player = new Plyr('#myVideo', {
            controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'fullscreen'],
            settings: ['captions', 'quality', 'speed'],
            captions: {
                active: true,
                language: 'auto',
            },
            keyboard: {
                focused: true,
                global: true,
            },
            tooltips: {
                controls: true,
                seek: true,
            },
            clickToPlay: true,
            keyboardShortcuts: {
                focused: true,
                global: true,
            },
            fullscreen: {
                enabled: true,
                fallback: true,
                iosNative: false,
            },
            storage: {
                enabled: true,
            },
            speed: {
                selected: 1,
                options: [0.5, 0.75, 1, 1.25, 1.5, 2],
            },
        });

        // Add event listener for full-screen change
        player.on('fullscreenchange', (event) => {
            const isLandscape = window.screen.orientation.angle === 90 || window.screen.orientation.angle === -90;
            
            if (event.detail && event.detail.fullscreen && isLandscape) {
                // Add any additional actions you want to perform when entering full-screen in landscape
                console.log('Entered full-screen in landscape mode');
            }
        });
    });
</script>

</script>


        </body>
        </html>
        <?php
    } else {
        echo "Invalid file index.";
    }
} else {
    echo "Invalid parameters.";
}

// Include the footer
include 'footer.php';
?>
