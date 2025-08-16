<?php
session_start();
session_destroy();
header("Location: ../auth/page.php");
exit;
