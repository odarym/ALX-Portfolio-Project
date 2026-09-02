<?php
/**
 * odakira/logout.php
 * User logout handler: terminates session and redirects to login page.
 */

// FIX: Added dedicated logout route to properly clear authenticated user session
if (isset($_SESSION['USER'])) {
    unset($_SESSION['USER']);
}

session_destroy();
redirect('login');
