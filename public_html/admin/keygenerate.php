<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include($_SERVER['DOCUMENT_ROOT'] . '/dacore/head.php');

if (!isset($_USER) || ($_USER['user_admin'] !== 'Administrator' && $_USER['user_admin'] !== 'Moderator')) {
    die("No admin, NO PASS!");
}

// Generador de clave de invitación
function generarInviteKey() {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $segmentos = [];

    for ($i = 0; $i < 3; $i++) {
        $segmento = '';
        for ($j = 0; $j < 4; $j++) {
            $segmento .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $segmentos[] = $segmento;
    }

    return 'BETTERBLX-' . implode('-', $segmentos);
}

$message = "";

if (isset($_POST['generate'])) {
    if (!isset($con)) {
        die('Error: no connection to DB');
    }

    $key = generarInviteKey();

    try {
        $stmt = $con->prepare("INSERT INTO invite_keys (invite_key, used, created_at) VALUES (:key, 0, NOW())");
        $stmt->execute([':key' => $key]);
        $message = "New Invite Key created: <b>{$key}</b>";
    } catch (PDOException $e) {
        $message = "Error saving key: " . $e->getMessage();
    }
}

$stmt = $con->prepare("SELECT * FROM invite_keys ORDER BY created_at DESC");
$stmt->execute();
$keys = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<title>
  <?=$sitename?> - Invite Key Generator
</title>
<div style="text-align:center; margin: 40px auto; width: 80%; max-width: 900px;">
    <h2>🔑 Lenop's Invite Key Generator</h2>

    <form method="POST">
        <button type="submit" name="generate" style="padding:10px 20px; font-size:16px;">Generate Key</button>
    </form>

    <?php if (!empty($message)): ?>
        <p style="margin-top:20px; color:blue;"><?php echo $message; ?></p>
    <?php endif; ?>

    <hr style="margin:30px 0;">

    <h3>All Invite Keys</h3>
    <table border="1" cellspacing="0" cellpadding="8" style="margin: 0 auto; border-collapse: collapse; width:100%;">
        <tr style="background-color:#f2f2f2;">
            <th>ID</th>
            <th>Invite Key</th>
            <th>Status</th>
            <th>Creation Date</th>
        </tr>
        <?php if (count($keys) > 0): ?>
            <?php foreach ($keys as $key): ?>
                <?php $isUsed = intval($key['used']) === 1; ?>
                <tr>
                    <td><?php echo htmlspecialchars($key['id']); ?></td>
                    <td style="font-family: monospace;"><?php echo htmlspecialchars($key['invite_key']); ?></td>
                    <td>
                        <?php if ($isUsed): ?>
                            <span style="background-color:#ffdddd; color:#900; padding:4px 8px; border-radius:4px;">Used</span>
                        <?php else: ?>
                            <span style="background-color:#ddffdd; color:#090; padding:4px 8px; border-radius:4px;">Unused</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($key['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">There are no invite keys.</td></tr>
        <?php endif; ?>
    </table>
</div>
