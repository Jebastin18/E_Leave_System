<?php
session_start();
session_unset();
session_destroy();
echo "<script>
    localStorage.removeItem('adminAuth');
    window.location.href = 'index.php';
</script>";
exit();
?>