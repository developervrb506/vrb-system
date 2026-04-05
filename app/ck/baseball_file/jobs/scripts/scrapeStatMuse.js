const puppeteer = require('puppeteer');
const fs = require('fs');



(async () => {
  const url = 'https://www.statmuse.com/mlb/ask/team-batting-averages-vs-lefties-this-season';
  //const browser = await puppeteer.launch({ headless: true });
  const browser = await puppeteer.launch({
  headless: true,
  args: ['--no-sandbox', '--disable-setuid-sandbox'],
  executablePath: puppeteer.executablePath()
});
  const page = await browser.newPage();

  await page.goto(url, { waitUntil: 'networkidle2' });

  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');
  const filename = `lefty_${yyyy}${dd}${mm}.json`;

  const results = await page.evaluate(() => {
    const data = [];
    document.querySelectorAll('tbody tr').forEach(row => {
      const teamTd = row.querySelector('td.text-left span');
      const avgTd = row.querySelector('td.text-right span');
      const team = teamTd ? teamTd.textContent.trim() : null;
      const avg = avgTd ? avgTd.textContent.trim() : null;
      if (team && avg && avg.startsWith('.')) {
        data.push({ team, avg });
      }
    });
    return data;
  });

  await browser.close();
  fs.writeFileSync(filename, JSON.stringify(results, null, 2), 'utf8');
  console.log(`✅ Archivo guardado como ${filename}`);
})();
