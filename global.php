<?php
function print_menu() {
	$link = mysqli_connect("localhost", "admin_sd", "df9(s1", "sweetdream");
	/* проверка подключения */
	if (mysqli_connect_errno()) {
		printf("Не удалось подключиться: %s\n", mysqli_connect_error());
		exit();
	}
	;
	if ($res = mysqli_query($link,'SELECT * FROM `upmenu` WHERE 1',MYSQLI_USE_RESULT)){
		echo "<ul class='hidden upMenu'>";	
		while ($content = mysqli_fetch_array($res, MYSQLI_NUM)){
			echo "<li><a href=$content[2]> $content[1] </a></li>";
		};
		echo "</ul>";
		mysqli_free_result($res);
	}
	/* закрываем подключение */
	mysqli_close($link);
}