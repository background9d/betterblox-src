<?php
$mensajes = [
    "Now with more bricks!",
    "100% nostalgia!",
    "Bricks are cool!",
    "This message is random!",
    "did you know roblox go boing boing yes?"
];

$mensaje_random = $mensajes[array_rand($mensajes)];
?>
<a href="/Default.aspx"><?php echo htmlspecialchars($mensaje_random); ?></a><br><br>
