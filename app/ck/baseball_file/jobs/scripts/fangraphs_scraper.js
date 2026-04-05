const puppeteer = require('puppeteer');
const fs = require('fs');

(async () => {
  const browser = await puppeteer.launch({ headless: true });
  const page = await browser.newPage();

  // Cargar cookies guardadas
  const cookies = JSON.parse(fs.readFileSync('cookies.json', 'utf8'));
  await page.setCookie(...cookies);

  const teamId = 15;
  const year = 2025;
  const apiUrl = `https://www.fangraphs.com/api/leaders/major-league/data?pos=all&stats=pit&lg=all&qual=0&type=0&season=${year}&month=0&season1=${year}&ind=0&team=${teamId}&players=0&pagenum=1&pageitems=100`;

  await page.goto('https://www.fangraphs.com/leaders/major-league', { waitUntil: 'networkidle2' });

  const title = await page.title();
  console.log("🎯 Título actual:", title);

  const bodyText = await page.evaluate(async (url) => {
    const res = await fetch(url, {
      method: 'GET',
      headers: { 'Accept': 'application/json' }
    });
    return await res.text();
  }, apiUrl);

  try {
    const json = JSON.parse(bodyText);
    const result = json.data.map(p => ({ name: p.Name, age: p.Age }));
    fs.writeFileSync("players.json", JSON.stringify(result, null, 2));
    console.log("✅ players.json generado.");
  } catch (e) {
    console.error("❌ Error al parsear JSON:", e.message);
    console.log("Respuesta recibida:", bodyText.substring(0, 300));
  }

  await browser.close();
})();
