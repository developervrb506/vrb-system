<!DOCTYPE html>
<html>
<head>
  <title>Cashier Bridge</title>
  <meta charset="UTF-8">

  <style>
    body {
  margin: 0;
  padding-top: 6px;
  background: transparent !important;
  font-family: Arial, sans-serif;
}

.bridge-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  height: 40px;
  width: 100%;
  flex-wrap: wrap; /* ?? clave para mobile */
}

.btn-cashier {
  background: #ffb000;
  border: 1px solid #000;
  padding: 5px 14px;
  font-size: 12px;
  cursor: pointer;
  font-weight: bold;
  border-radius: 3px;
  white-space: nowrap;
}

.info-text {
  font-size: 12px;
  color: #ffffff;
  font-weight: bold;
  line-height: 1.2;
  text-align: left;
}  </style>
</head>

<body>

<div class="bridge-container">

 
  <button class="btn-cashier" onclick="goCashier()">
    CASHIER
  </button>

 <!--
<a   class="btn-cashier" href="https://vrb-cashier.vercel.app/bitbet/23C2A58/sign-in" target="_blank">
  CASHIER
</a>-->


  <!-- TEXTO -->
  <div class="info-text">
     <!--Wagering - 866-921-8362<br>
    Agents - 866-968-7946 -->
  </div>

</div>

<script>
let parentDomain = null;

/**
 * 1. Primero intenta leer el dominio desde la URL:
 *    index.php?domain=bitbet.com
 */
const params = new URLSearchParams(window.location.search);
const domainFromUrl = params.get("domain");

if (domainFromUrl) {
  parentDomain = domainFromUrl;
  console.log("Dominio detectado por URL:", parentDomain);
}

/**
 * 2. Respaldo: intenta detectar el dominio desde document.referrer
 *    Esto funciona cuando el iframe fue cargado desde otro sitio.
 */
if (!parentDomain && document.referrer) {
  try {
    parentDomain = new URL(document.referrer).hostname;
    console.log("Dominio detectado por referrer:", parentDomain);
  } catch (e) {
    console.warn("No se pudo leer document.referrer:", e);
  }
}

/**
 * 3. Último respaldo: recibe el dominio por postMessage
 *    Esto mantiene compatibilidad con la lógica anterior.
 */
window.addEventListener("message", function(event) {
  if (event.data && event.data.domain) {
    parentDomain = event.data.domain;
    console.log("Dominio detectado por postMessage:", parentDomain);
  }
});

/**
 * Acción del botón CASHIER
 */
async function goCashier() {
  const domain = parentDomain;

  if (!domain) {
    alert("Domain was not detected for this site.");
    return;
  }

  try {
    const lookupUrl =
      "https://cashier.vrbmarketing.com/api/cashier-lookup?domain=" +
      encodeURIComponent(domain);

    console.log("Cashier lookup URL:", lookupUrl);

    const res = await fetch(lookupUrl);

    if (!res.ok) {
      alert("There is not Cashier active for this site.");
      return;
    }

    const data = await res.json();

    if (!data.url) {
      alert("Cashier URL was not found for this site.");
      return;
    }

    window.open(data.url, "_blank");

  } catch (e) {
    console.error("Cashier lookup error:", e);
    alert("There is not Cashier active for this site.");
  }
}
</script>
<? /*
<script>
const params = new URLSearchParams(window.location.search);
let parentDomain = params.get("domain") || null;

// Recibir dominio desde Bitbet
window.addEventListener("message", function(event) {
  if (event.data && event.data.domain) {
    parentDomain = event.data.domain;
    console.log("Dominio detectado:", parentDomain);
  }
});


  async function goCashier() {                                                                                                     const domain = parentDomain; // already set in the page                                                                    
    try {                                                                                                                            const res = await fetch(                                                                                                 
        "https://cashier.vrbmarketing.com/api/cashier-lookup?domain=" + encodeURIComponent(domain)
      );
      if (!res.ok) {
        alert("There is not Cashier active for this site.");
        return;
      }
      const data = await res.json();
      window.open(data.url, "_blank");
    } catch (e) {
      alert("There is not Cashier active for this site.");
    }
  }

</script> */ ?>

</body>
</html>