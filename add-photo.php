<?php   if(is_user_logged_in()): ?>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <p>Image:</p>
        <input type="file" name="img">
        <p>Author:</p>
        <input type="text" name="author">
        <p>Link:</p>
        <input type="text" name="link">
        <input type="submit" name="submit" value="Upload">
    </form>
<?php   endif; ?>
<?php   else: ?>
    <p>You're not logged in, sorry :/</p>
    <meta http-equiv="refresh" content="2; URL='http://peneplena.ct8.pl/wp-admin/'" />
<?php   endif; ?>
