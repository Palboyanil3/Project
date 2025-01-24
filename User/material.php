<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

// Fetch courses from the database
$sql = "SELECT * FROM our_courses";  // Adjust the query as needed to match your database structure
$result = $conn->query($sql);
$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    } // Close the while loop
} // Close the if block
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding-top: 20px;
            position: fixed;
            height: 100%;
        }

        .sidebar h1 {
            text-align: center;
            color: #ecf0f1;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
            border-radius: 5px;
        }

        .container {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }

        .card {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .styled-table th, .styled-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .styled-table th {
            background-color: #34495e;
            color: white;
        }

        .styled-table tr:hover {
            background-color: #f1f1f1;
        }

        /* YouTube Video Section */
        .youtube-container {
            margin-top: 20px;
        }

        select {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .video-frame {
            width: 100%;
            height: 315px;
            margin-bottom: 20px;
        }

        .video-title {
            font-size: 18px;
            margin-top: 10px;
        }

        .video-description {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php';?>

    <!-- Main Content -->
    <div class="container">
        <h3>Select Course to View Videos</h3>

        <!-- Course Dropdown -->
        <select id="courseSelector" onchange="fetchYouTubeVideos()">
            <option value="none">Select a Course</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?php echo htmlspecialchars($course['course_name']); ?>">
                    <?php echo htmlspecialchars($course['course_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- YouTube Videos -->
        <div id="youtubeVideos" class="youtube-container"></div>
    </div> <!-- End of container -->

    <script>
        function fetchYouTubeVideos() {
            const course = document.getElementById('courseSelector').value;
            const youtubeVideosDiv = document.getElementById('youtubeVideos');

            if (course === "none") {
                youtubeVideosDiv.innerHTML = "";
                return;
            }

            const youtubeApiKey = 'AIzaSyCX1UFWKzmWGbyHeB8C1cYAs7IdFK2fBuc';  // Your actual API key here
            const query = encodeURIComponent(course);
            const youtubeUrl = `https://www.googleapis.com/youtube/v3/search?part=snippet&q=${query}&key=${youtubeApiKey}`;

            // Clear previous results
            youtubeVideosDiv.innerHTML = "";

            // Fetch YouTube videos using the API
            fetch(youtubeUrl)
                .then(response => response.json())
                .then(data => {
                    const items = data.items || [];
                    if (items.length > 0) {
                        items.forEach(item => {
                            const videoId = item.id.videoId;
                            const title = item.snippet.title;
                            const description = item.snippet.description;

                            const videoEmbed = document.createElement('iframe');
                            videoEmbed.classList.add('video-frame');
                            videoEmbed.src = `https://www.youtube.com/embed/${videoId}`;
                            videoEmbed.frameBorder = 0;
                            videoEmbed.allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture";
                            videoEmbed.allowFullscreen = true;

                            const videoTitle = document.createElement('h4');
                            videoTitle.classList.add('video-title');
                            videoTitle.textContent = title;

                            const videoDesc = document.createElement('p');
                            videoDesc.classList.add('video-description');
                            videoDesc.textContent = description;

                            youtubeVideosDiv.appendChild(videoTitle);
                            youtubeVideosDiv.appendChild(videoEmbed);
                            youtubeVideosDiv.appendChild(videoDesc);
                        });
                    } else {
                        youtubeVideosDiv.innerHTML = "No YouTube videos found for this course.";
                    }
                })
                .catch(error => {
                    console.error('Error fetching YouTube videos:', error);
                    youtubeVideosDiv.innerHTML = "An error occurred while fetching YouTube videos.";
                });
        }
    </script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
