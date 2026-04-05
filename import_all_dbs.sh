#!/bin/bash

DB_PATH="/Users/alexisandrade/Documents/DBS"

MYSQL_CONTAINER="mysql_db"

for file in "$DB_PATH"/*.sql; do
    filename=$(basename "$file")

    # Extraer nombre DB
    db_name=$(echo "$filename" | awk -F'_2026-03-12' '{print $1}')

    echo "=============================="
    echo "Archivo: $filename"
    echo "Base de datos: $db_name"

    # Crear DB
    docker exec -i $MYSQL_CONTAINER mysql -u root -proot -e "CREATE 
DATABASE IF NOT EXISTS \`$db_name\`;"

    echo "Importando..."

    # IMPORTAR USANDO ROOT (clave)
docker exec -i $MYSQL_CONTAINER mysql -u root -proot $db_name <"$file"
    echo "OK: $db_name"
done

echo "🎉 Importación completa"
