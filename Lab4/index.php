<html>
<head>
<title>Lab 4</title>
</head>
<body>
    <p>
        <a href=https://drive.google.com/drive/folders/11AFMoyQc1h8zg0VKGVY7nt-x6R3wl7FM?usp=sharing>Google Drive</a>
    </p>
    <p>
        <a href=admin>Admin Control Panel</a>
    </p>
    <p>
        <form method="POST" action="submit_lab4.php">
            <label>Username: <input type="text" name="username" required></label>
            <br>
            <label>Email: <input type="email" name="email" required></label>
            <br>
            <input type="submit">
        </form>
    </p>
    <p>
        <?php
            echo "<p> You are: ";
            $ip = $_SERVER["REMOTE_ADDR"];
            if($ip == "localhost" || $ip == "127.0.0.1" || $ip == "192.168.115.249") {
                echo "Theo";
            } else if ($ip == "192.168.115.133") {
                echo "Paul";
            } else if ($ip == "192.168.115.221") {
                echo "Mohammad";
            } else {
                echo "Unknown IP: " . $ip;
            }
            echo "</p>";
        ?>
    </p>
</body>
</html>