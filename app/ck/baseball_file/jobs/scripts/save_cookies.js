const puppeteer = require('puppeteer');
const fs = require('fs');

(async () => {
  const browser = await puppeteer.launch({ headless: false }); // 🧠 Manual
  const page = await browser.newPage();

  await page.goto('https://www.fangraphs.com/leaders/major-league');

  console.log("👉 Pasa el challenge manualmente si aparece, luego presiona ENTER aquí para guardar cookies.");
  process.stdin.once('data', async () => {
    const cookies = await page.cookies();
    fs.writeFileSync('cookies.json', JSON.stringify(cookies, null, 2));
    console.log("✅ Cookies guardadas en cookies.json");
    await browser.close();
    process.exit();
  });
})();
