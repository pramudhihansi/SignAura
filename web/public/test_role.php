<?php
session_start();
require_once "../db.php";

echo "<h3>Role Selection Test</h3>";

if(isset($_POST['test_role'])) {
    echo "<strong>Submitted role:</strong> " . $_POST['role'] . "<br>";
    echo "<strong>Expected:</strong> admin<br>";
    echo "<strong>Match:</strong> " . ($_POST['role'] === 'admin' ? "✅ YES" : "❌ NO");
}

echo "<hr>";

echo "<h4>Test Form:</h4>";
echo "<form method='POST'>";
echo "<label><input type='radio' name='role' value='user' checked> User</label><br>";
echo "<label><input type='radio' name='role' value='admin'> Admin</label><br>";
echo "<button type='submit' name='test_role' value='1'>Test</button>";
echo "</form>";

echo "<hr>";
echo "<h4>Current Session:</h4>";
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT username, role FROM users WHERE id='$user_id'");
    if($row = mysqli_fetch_assoc($result)) {
        echo "Logged in as: <strong>{$row['username']}</strong><br>";
        echo "Role: <strong>" . strtoupper($row['role']) . "</strong>";
    }
} else {
    echo "Not logged in";
}

echo "<br><br><a href='../index.php'>Home</a>";
?>
