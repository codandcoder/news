<?php

session_start();

session_unregister("log_author_id");
session_unregister("log_username");
session_unregister("log_name");
session_unregister("log_password");
session_unregister("log_lastvisit");

session_destroy();
Header("location: login.php");

?>