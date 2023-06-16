<?php
session_save_path('C:\xampp\htdocs\Internproject\htmlnew\sessions');
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // Generate a unique filename for the blog post
    $filename = $title . '.html';

    // Create the HTML content for the blog post
    $html = "<h1>$title</h1>";
    $html .= "<p>By $author</p>";
    $html .= "<div>$content</div>";

    // Save the blog post as an HTML file
    $savePath = 'C:\xampp\htdocs\Internproject\htmlnew\\' . $filename;
    file_put_contents($savePath, $html);

    // Store the filename in a session variable or array
    if (!isset($_SESSION['filenames'])) {
        $_SESSION['filenames'] = array();
    }
    $_SESSION['filenames'][] = $filename;

    // Limit the number of stored filenames to 5
    if (count($_SESSION['filenames']) > 5) {
        array_shift($_SESSION['filenames']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create New Post</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <header>
    <h1>My Blog</h1>
  </header>

  <div class="container">
    <h2>Create New Post</h2>
    <form method="post">
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
      </div>
      <div class="form-group">
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>
      </div>
      <div class="form-group">
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="10" required></textarea>
      </div>
      <button type="submit">Publish</button>
    </form>

    <?php
    // Display the recently saved blog posts if they exist
    if (isset($_SESSION['filenames'])) {
        echo "<h2>Recently Published:</h2>";
        $recentFilenames = array_reverse($_SESSION['filenames']);
        foreach ($recentFilenames as $filename) {
            echo "<div>";
            include("htmlnew/" . $filename);
            echo "</div>";
        }
    }
    ?>
  </div>
</body>
</html>
