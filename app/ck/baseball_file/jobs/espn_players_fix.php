<? require_once(ROOT_PATH . "/ck/db/handler.php"); 

$players = get_player_espn_text();
$teams = get_teams_test();

function get_teams_test(){
  baseball_db();
  $sql = "SELECT espn_team,team_name  FROM `stadium` ";
  return get_str($sql,false,'team_name');
}


echo "<pre>";
//**print_r($teams); exit;



function get_player_espn_text(){
  baseball_db();
  $sql = "SELECT *  FROM `player` WHERE `espn_player` = 0 AND `type` LIKE 'pitcher'  and id >= 6264
ORDER BY `player`.`id` ASC LIMIT 100";
  return get_str($sql);
}

function getEspnPlayerData($name) {
    $url = 'https://site.web.api.espn.com/apis/search/v2?region=us&lang=en&limit=50&page=1&type=player&dtciVideoSearch=true&query=' . urlencode($name);
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    // Verifica si hay resultados
    if (!isset($data['results'][0]['contents']) || !is_array($data['results'][0]['contents'])) {
        return null;
    }

    $mlbPlayers = array_filter($data['results'][0]['contents'], function ($p) {
        return isset($p['description']) && $p['description'] === 'MLB';
    });

    // Solo 1 jugador de MLB
    if (count($mlbPlayers) === 1) {
        $playerData = array_values($mlbPlayers)[0];

        $uidParts = explode('~', $playerData['uid']);
        $id = isset($uidParts[2]) ? str_replace('a:', '', $uidParts[2]) : null;

        return [
            'id' => $id,
            'team' => trim($playerData['subtitle'] ?? ''),
            'image' => $playerData['image']['default'] ?? '',
            'name' => $playerData['displayName'] ?? $name
        ];
    }

    // Ningún jugador o más de uno de MLB
    return null;
}


/*
function getEspnPlayerData($name) {
    $url = 'https://site.web.api.espn.com/apis/search/v2?region=us&lang=en&limit=50&page=1&type=player&dtciVideoSearch=true&query=' . urlencode($name);
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    if (isset($data['results'][0]['contents']) && count($data['results'][0]['contents']) === 1) {
        $playerData = $data['results'][0]['contents'][0];
        $uidParts = explode('~', $playerData['uid']);
        $id = isset($uidParts[2]) ? str_replace('a:', '', $uidParts[2]) : null;

        return [
            'id' => $id,
            'team' => trim($playerData['subtitle'] ?? ''),
            'image' => $playerData['image']['default'] ?? '',
            'name' => $playerData['displayName'] ?? $name
        ];
    }

    return null;
} */
?>

<button onclick="updateAllPlayers()">UPDATE ALL</button>


<table border="1" cellpadding="5" id="playersTable">
    <thead>
        <tr>
            <th>Player ID</th>
            <th>Nombre</th>
            <th>ESPN ID</th>
            <th>Equipo</th>
            <th>TEAM ID</th>
            <th>Imagen</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($players as $p): ?>
            <?php
                $id = $p['id'];
                $name = $p['player'];
                $espnData = getEspnPlayerData($name);
            ?>
            <?php if ($espnData): ?>
                <?php
                    $teamName = $espnData['team'];
                    $teamId = isset($teams[$teamName]) ? $teams[$teamName]['espn_team'] : null;
                ?>
                <tr id="row-<?= $id ?>">
                    <td><?= $id ?></td>
                    <td><?= $espnData['name'] ?></td>
                    <td><?= $espnData['id'] ?></td>
                    <td><?= $teamName ?></td>
                    <td><?= $teamId ?? 'N/A' ?></td>
                    <td><img src="<?= $espnData['image'] ?>" width="50"></td>
                    <td>
                        <?php if ($teamId !== null): ?>
                        <button onclick="updatePlayer(
                            <?= $id ?>,
                            <?= $teamId ?>,
                            <?= $espnData['id'] ?>,
                            '<?= $espnData['image'] ?>',
                            '<?= addslashes($espnData['name']) ?>'
                        )">Update</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php else: ?>
                <tr><td colspan="7">No único resultado para <strong><?= $name ?></strong></td></tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
function updatePlayer(localId, teamId, espnId, image, name) {
    const url = `espn_players_fix_action.php?id=${localId}&team_id=${teamId}&espn_id=${espnId}&image=${encodeURIComponent(image)}`;

    fetch(url)
        .then(response => {
            if (response.ok) {
                document.getElementById('row-' + localId).remove();
                console.log(`${name} UPDATED`);
            } else {
                console.error(`Error al actualizar jugador ${name}`);
            }
        })
        .catch(err => console.error(`Error en conexión para ${name}`, err));
}



function updateAllPlayers() {
    const buttons = document.querySelectorAll('button[onclick^="updatePlayer"]');
    let delay = 0;

    buttons.forEach((btn, index) => {
        // Espaciamos las actualizaciones para no saturar el servidor
        setTimeout(() => {
            btn.click();
        }, delay);
        delay += 500; // 500ms entre cada uno (ajustable)
    });
}




</script>