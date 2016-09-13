<?php
if (isset($_SESSION['sess_name'])) {
echo "<h2>Добро пожаловать ". $_SESSION['sess_name']."!</h2>";
} else echo "<h2>Добро пожаловать!</h2>";
?>

<h3>Факты</h3>

<p class="describe">
    На первом месте - качество!<br><br>
    В нашем магазине вы найдете ...бла бла бла <br>
</p>