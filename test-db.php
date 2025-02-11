<?php
require_once "./database/db.php";

if ($conn) {
    echo "✅ Database Connected Successfully!";
} else {
    echo "❌ Database Connection Failed!";
}
?>
