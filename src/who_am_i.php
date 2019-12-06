<?php
echo '<pre>';

$user = system('whoami', $retval);

echo '
</pre>
<hr />Current username: ' . $user . '
<hr />Return value: ' . $retval;
?>