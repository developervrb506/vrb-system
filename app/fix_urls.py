import re, os, sys

URL = 'http://localhost:8080'

def process_css(content):
    return content.replace(URL, '')

def process_php(content):
    attrs = r'(?:href|src|action|data-url|data-href|data-src|poster|content)'

    # 1. CSS url() inline
    content = re.sub(r'url\(http://localhost:8080/', r'url(/', content)
    content = re.sub(r'url\("http://localhost:8080/', r'url("/', content)

    # 2. HTML atributos doble-comilla (espacio opcional antes/dentro del valor)
    #    Cubre: href="URL/path"  href= "URL/path"  href=" URL/path"
    content = re.sub(r'(' + attrs + r')=\s*"\s*http://localhost:8080/',
                     r'\1="<?= BASE_URL ?>/', content)

    # 2b. HTML atributos sin path (URL exacta como valor del atributo)
    #    Ej: href="http://localhost:8080"  href=" http://localhost:8080"
    content = re.sub(r'(' + attrs + r')=\s*"\s*http://localhost:8080"',
                     r'\1="<?= BASE_URL ?>"', content)

    # 3. PHP header() Location redirect (insensible a mayúsculas)
    content = re.sub(r'"[Ll]ocation: http://localhost:8080/',
                     r'"Location: " . BASE_URL . "/', content)
    # header sin path: header("Location: http://localhost:8080")
    content = re.sub(r'"[Ll]ocation: http://localhost:8080"',
                     r'"Location: " . BASE_URL', content)

    # 4. Meta-refresh: content="N; url=URL/path"
    content = re.sub(r'(content=\s*"[^"]*?url=)http://localhost:8080/',
                     r'\1<?= BASE_URL ?>/', content)

    # 5. HTML atributos comilla-simple dentro de string PHP doble-comilla
    #    Ej: $html .= "<a href='URL/path'>"
    content = re.sub(r"(" + attrs + r")='http://localhost:8080/",
                     r"\1='\" . BASE_URL . \"/", content)

    # 6. PHP assignment con comilla simple: $var = 'URL/path'  $code= 'URL/path'
    content = re.sub(r"(=\s*)'http://localhost:8080/",
                     r"\1BASE_URL . '/", content)
    content = re.sub(r"(=\s*)'http://localhost:8080'",
                     r'\1BASE_URL', content)

    # 6b. JS function calls con comilla simple en archivos PHP (contexto HTML/JS)
    #     Ej: window.open('URL/...')  fetch('URL/...')  load_url_content_in_div('URL/...')
    #     Nota: los file_get_contents PHP usan comilla doble (cubierto en paso 7)
    content = re.sub(r"\('http://localhost:8080/",
                     r"('<?= BASE_URL ?>/", content)

    # 7. Strings PHP restantes doble-comilla (var, comparación, concatenación, arg)
    #    Ej: $x = "URL/path"  == "URL/path"  . "URL/path"  ("URL/path"
    content = content.replace('"' + URL + '/', 'BASE_URL . "/')

    # 8. URL exacta sin path en doble-comilla PHP (no HTML attr — ya cubierto en 2b)
    #    Ej: return "http://localhost:8080"   $x = "http://localhost:8080"
    content = content.replace('"' + URL + '"', 'BASE_URL')

    return content

def process_js(content):
    # JS: eliminar host dejando paths absolutos
    return content.replace(URL, '')

def process_file(path):
    try:
        with open(path, 'r', encoding='utf-8', errors='replace') as f:
            original = f.read()
    except Exception as e:
        print(f"  ERROR leyendo {path}: {e}")
        return 0

    if URL not in original:
        return 0

    ext = os.path.splitext(path)[1].lower()
    if ext == '.css':
        updated = process_css(original)
    elif ext == '.php':
        updated = process_php(original)
    elif ext == '.js':
        updated = process_js(original)
    else:
        return 0

    count = original.count(URL)
    remaining = updated.count(URL)

    if '--dry-run' not in sys.argv:
        try:
            with open(path, 'w', encoding='utf-8') as f:
                f.write(updated)
        except Exception as e:
            print(f"  ERROR escribiendo {path}: {e}")
            return 0

    if remaining:
        print(f"  ⚠️  {remaining} sin resolver en: {path}")

    return count

# ── main ──────────────────────────────────────────────────────────────────────
dry = '--dry-run' in sys.argv
if dry:
    print("DRY RUN — no se modifica ningún archivo\n")

total_replaced = 0
total_files = 0

base_dir = os.path.dirname(os.path.abspath(__file__))

for root, dirs, files in os.walk(base_dir):
    dirs[:] = [d for d in dirs if d not in ['node_modules', '.git', '.svn']]
    for fname in files:
        if not fname.endswith(('.php', '.css', '.js')):
            continue
        fpath = os.path.join(root, fname)
        n = process_file(fpath)
        if n:
            rel = os.path.relpath(fpath, base_dir)
            print(f"{n:4d}  {rel}")
            total_replaced += n
            total_files += 1

print(f"\n{'[DRY RUN] ' if dry else ''}Reemplazados: {total_replaced} ocurrencias en {total_files} archivos")
