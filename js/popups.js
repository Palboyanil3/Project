<script>
    function showPopup(event) {
        var popup = document.getElementById('popup');

        // Toggle popup visibility
        if (popup.style.display === 'none' || popup.style.display === '') {
            var rect = event.target.getBoundingClientRect();

            // Position the popup near the image or username
            popup.style.top = rect.top + window.scrollY + 30 + 'px'; // 30px offset for better placement
            popup.style.left = rect.left + window.scrollX + 'px';

            popup.style.display = 'block';
        } else {
            popup.style.display = 'none';
        }
    }

    // Event listener for user image and username click
    document.getElementById('userImage').addEventListener('click', showPopup);
    document.getElementById('username').addEventListener('click', showPopup);

    // Hide the popup when clicking outside
    document.addEventListener('click', function(event) {
        var popup = document.getElementById('popup');
        var image = document.getElementById('userImage');
        var username = document.getElementById('username');

        if (!popup.contains(event.target) && event.target !== image && event.target !== username) {
            popup.style.display = 'none';
        }
    });
</script>