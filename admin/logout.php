<?php
session_start();

session_unregister("a_admin_id");
session_unregister("a_username");
session_unregister("a_name");
session_unregister("a_password");
session_unregister("a_lastvisit");

session_destroy();
Header("location: login.php");

?>