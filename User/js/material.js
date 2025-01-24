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
                    videoEmbed.width = 560;
                    videoEmbed.height = 315;
                    videoEmbed.src = `https://www.youtube.com/embed/${videoId}`;
                    videoEmbed.frameBorder = 0;
                    videoEmbed.allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture";
                    videoEmbed.allowFullscreen = true;

                    const videoTitle = document.createElement('h4');
                    videoTitle.textContent = title;

                    const videoDesc = document.createElement('p');
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
