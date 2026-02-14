<?php
// Quick role checker - delete after use
require_once "../db.php";

echo "Checking database connection... ";
if(!$conn) die("FAILED");

echo "✅ Connected<br><br>";

$users = mysqli_query($conn, "SELECT id, username, role FROM users ORDER BY id");
if(mysqli_num_rows($users) == 0) {
    echo "No users found!";
    exit();
}

echo "<h3>All Users:</h3>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Username</th><th>Role</th></tr>";
while($row = mysqli_fetch_assoc($users)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
    echo "<td><strong>" . strtoupper($row['role']) . "</strong></td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><br>";
echo "<a href='index.php'>Go to Homepage</a>";
?>
