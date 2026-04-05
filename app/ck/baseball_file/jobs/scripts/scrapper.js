const fs = require('fs');

const teamIds = [15, 16, 2, 3, 17, 4, 18, 5, 19, 6, 21, 7, 1, 22, 20, 23, 8, 25, 9, 10, 26, 27, 29, 30, 11, 28, 12, 13, 14, 24];
const year = 2025;
const apiKey = "d89099a8d2e0f992390ffaa2f09de145"; // ← Cambia por tu API Key de ScraperAPI

const fetch = (...args) => import('node-fetch').then(({default: fetch}) => fetch(...args)); // Solo si no usas Node 18+

(async () => {
  for (const teamId of teamIds) {
    const urlOriginal = `https://www.fangraphs.com/api/leaders/major-league/data?pos=all&stats=pit&lg=all&qual=0&type=0&season=${year}&month=0&season1=${year}&ind=0&team=${teamId}&players=0&pagenum=1&pageitems=100`;
    const apiUrl = `http://api.scraperapi.com?api_key=${apiKey}&url=${encodeURIComponent(urlOriginal)}`;

    console.log(`🔍 Procesando equipo ${teamId}...`);

    try {
      const res = await fetch(apiUrl);
      const json = await res.json();

      const result = json.data.map(p => {
        const nameRaw = p.Name;
        const nameClean = nameRaw.replace(/<[^>]*>/g, '').trim();
        return {
          Player: nameClean,
          Teamid: p.teamid,
          Player_id: p.playerid,
          Team: p.TeamName,
          Era: p.ERA

        };
      });

      fs.writeFileSync(`${teamId}.json`, JSON.stringify(result, null, 2));
      console.log(`✅ Archivo ${teamId}.json guardado correctamente.`);

    } catch (err) {
      console.error(`❌ Error con equipo ${teamId}:`, err.message);
    }
  }

  console.log("🎉 ¡Todos los equipos procesados!");
})();
