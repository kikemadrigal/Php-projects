#make_response nos permite ejecutar redirecciones hacia otras rutas pasando parámetros, crear cookies, etc, recive un calback que es redirect que tiene una ruta
from flask import Flask, render_template
import os
import sqlite3



app = Flask(__name__)
conexion=None


def crear_tabla_usuarios():
    cursor=conexion.cursor()
    cursor.execute('''
    CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT,
            dni TEXT,
            fecha_nacimiento TEXT,
            direccion TEXT,
            correo_electronico TEXT
    );         
    ''')
    conexion.commit()

def anadir_usuarios():
    cursor=conexion.cursor()
    cursor.executemany("insert into usuarios values (?,?,?,?,?,?);",
        [
            (None,'Loreto','36581601D','04-05-1998','Calle Gutierrez mellado, 13','Loreto@gmail.com'),
            (None,'Carlos','56396587N','05-11-1980','Calle princesa, 6','Carlos@gmail.com'),
            (None,'Pablo','25649656X','10-09-1990','Avenida del mar, 12','Pablo@gmail.com'),
            (None,'David','65365246M','05-06-2000','Calle Fiesta, 2','David@gmail.com'),
            (None,'Sergio','25469632F','01-08-2005','Calle reina Sofía, 4','Sergio@gmail.com'),
            (None,'Angel','45635423L','14-11-1983','Calle de los apóstoles, 54','Angel@gmail.com'),

        ])
    conexion.commit()

def dame_usuarios():
    cursor=conexion.cursor()
    cursor.execute("select * from usuarios")
    tuplas=cursor.fetchall()
    if len(tuplas)==0:
        return None
    else:
        return tuplas









@app.route("/")
@app.route("/index")
def index():
    # Inicializamos la variable conexion como global
    global conexion
    SQLITE_DB = 'avanza.db'
    inicializar_db=False
    if not os.path.exists(SQLITE_DB):
        inicializar_db=True
    conexion=sqlite3.connect(SQLITE_DB, check_same_thread=False)
    # Se crea la tabla y los archivos si el archivo avanza.db no existe
    if inicializar_db:
        crear_tabla_usuarios()
        anadir_usuarios()
    usuarios=dame_usuarios()
    print(usuarios)
    return render_template("index.html", usuarios=usuarios)


@app.route("/about")
def about():
    return render_template("about.html")


# Start the Server
if __name__ == "__main__":
    #app.run(host="0.0.0.0", port=3000, debug=True)
    app.run(debug=True)






















