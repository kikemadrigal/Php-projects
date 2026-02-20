
import sqlite3
import os
class SqliteClient:
    def __init__(self):
        SQLITE_DB="avanza.db"
        inicializar_bd=False
        if not os.path.exists(SQLITE_DB):
            inicializar_bd=True
        self.conexion=sqlite3.connect(SQLITE_DB, check_same_thread=False)
        self.cursor=self.conexion.cursor()
        if inicializar_bd:
            self.create_table_usuarios()
            self.create_table_eventos()
            self.add_fake_users()
            self.add_fake_eventos()

    def close(self):
        self.conexion.close()
    def get_connection(self):
        return self.conexion
    def get_cursor(self):
        return self.cursor

    # USUARIOS
    #######################################################  
    def create_table_usuarios(self):
        """
        Roll: 
        0: User
        1: subscriber
        3: Admin
        
        Validate:
        0: Not validated
        1: Validated

        """
        self.cursor.execute('''
        CREATE TABLE IF NOT EXISTS usuarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT,
                password TEXT,
                dni TEXT,
                fecha_nacimiento TEXT,
                direccion TEXT,
                email TEXT,
                roll,
                validate
        );         
        ''')
        self.conexion.commit()        
    def add_fake_users(self):
        self.cursor.executemany("insert into usuarios values (?,?,?,?,?,?,?,?,?);",
            [
                (None,'kike','1234','34831601X','01-11-2000','Calle del Mar, 23','kike@gmail.com',3,1),
                (None,'Loreto','1234','36581601D','04-05-1998','Calle Gutierrez mellado, 13','Loreto@gmail.com',0,1),
                (None,'Carlos','1234','56396587N','05-11-1980','Calle princesa, 6','Carlos@gmail.com',0,1),
                (None,'Pablo','1234','25649656X','10-09-1990','Avenida del mar, 12','Pablo@gmail.com',0,1),
                (None,'David','1234','65365246M','05-06-2000','Calle Fiesta, 2','David@gmail.com',0,1),
                (None,'Sergio','1234','25469632F','01-08-2005','Calle reina Sofía, 4','Sergio@gmail.com',0,1),
                (None,'Angel','1234','45635423L','14-11-1983','Calle de los apóstoles, 54','Angel@gmail.com',0,1)
            ]
        )  
        self.conexion.commit()
    def get_all_usuarios(self):
        self.cursor.execute("select * from usuarios")
        tuplas=self.cursor.fetchall()
        if len(tuplas)==0:
            return None
        else:
            return tuplas
    def mostrar_usuario_por_id(self,id):
        self.cursor.execute("select * from usuarios where id=?",(id,))
        tuplas=self.cursor.fetchall()
        if len(tuplas)==0:
            return None
        else:
            return tuplas
    def crear_usuario(self,nombre,password,dni,fecha_nacimiento,direccion,email,roll=0,validate=0):
        self.cursor.execute("insert into usuarios values (?,?,?,?,?,?,?,?);",
            (None,nombre,password,dni,fecha_nacimiento,direccion,email,roll,validate))
        self.conexion.commit()
    def get_all_eventos_by_user(self,id):
        self.cursor.execute("select * from eventos where id=?",(id,))
        tuplas=self.cursor.fetchall()
        if len(tuplas)==0:
            return None
        else:
            return tuplas





        
   # EVENTOS
    #######################################################
    def create_table_eventos(self): 
        self.cursor.execute('''
        CREATE TABLE IF NOT EXISTS eventos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT,
                fecha DATE,
                direccion TEXT,
                cantidad INTEGER,
                precio FLOAT
        );         
        ''')
        self.conexion.commit()
    def add_fake_eventos(self):
        self.cursor.executemany("insert into eventos values (?,?,?,?,?,?);",
            [
                (None,'Concierto de los Beatles','01-01-2024','Calle del Mar, 23',10,10),
                (None,'Cena noche vieja','31-12-2024','Calle de Marcos, 14',15,20),
                (None,'Taller de cocina','06-01-2024','Centro de salud la luna, 23',20,4),
                (None,'Ver belén','04-01-2024','Catedral de Murcia, s/n',5,5),
                (None,'hacer senderismo por la noche','20-01-2024','Moratalla, calle del mar, 14',14,10)
            ]
        )
        self.conexion.commit()



    def get_all_eventos(self):
        self.cursor.execute("select * from eventos")
        tuplas=self.cursor.fetchall()
        if len(tuplas)==0:
            return None
        else:
            return tuplas



   # AUTH
    #######################################################
    def login_user(self,nombre):
        self.cursor.execute("select * from usuarios where nombre=?",(nombre,))
        tuplas=self.cursor.fetchall()
        if len(tuplas)==0:
            return None
        else:
            return tuplas