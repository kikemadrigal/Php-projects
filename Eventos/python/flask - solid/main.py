#make_response nos permite ejecutar redirecciones hacia otras rutas pasando parámetros, crear cookies, etc, recive un calback que es redirect que tiene una ruta
from flask import Flask, render_template,redirect,request, flash, url_for, session
from sqliteClient import SqliteClient
#pip install flask-mysqldb

app = Flask(__name__)
sqliteClient=SqliteClient()
# Le decimos como va a ir protegida nuestra sesión
app.secret_key = "mi secret key"





@app.route("/")
@app.route("/index")
def index():
    eventos=sqliteClient.get_all_eventos()
    return render_template("index.html", eventos=eventos)
@app.route("/about")
def about():
    return render_template("about.html")
@app.route("/contact")
def contact():
    return render_template("contact.html")

# AUTH
###################################################
@app.route("/form-register")
def form_register():
    return render_template("auth/form-register.html")
@app.route("/register", methods=["POST"])
def register():
    if request.method == "POST":
        nombre = request.form["nombre"]
        dni = request.form["dni"]
        fecha_nacimiento = request.form["fecha_nacimiento"]
        direccion = request.form["direccion"]
        email = request.form["email"]
        sqliteClient.create_user(nombre, dni, fecha_nacimiento, direccion, email)
    #return redirect("/")
    # esto es como llamar a la ruta index de arriba
    flash("Se ha enviado un mensaje para validar su cuenta, revisar su bandeja de entrada")
    return redirect(url_for("form_register"))

@app.route("/form-login")
def form_login():
    return render_template("auth/form-login.html")
@app.route("/login", methods=["POST","GET"])
def login():
    if request.method == "POST":
        nombre = request.form["nombre"]
        clave = request.form["password"]
        users=sqliteClient.login_user(nombre)

        if users==None:
            flash("El usuario no existe")
            return redirect(url_for("form_login", nombre=nombre, clave=clave))
        # Si el usuario existe
        else:
            user=users[0]
            #Si la contrase;a es incorrecta
            if user[2]!=clave:
                flash("La clave es incorrecta ")
                return redirect(url_for("form_login", nombre=nombre, clave=clave))
            else:
                print ("La clave es correcta")
                # Si el usuario no ha validado su cuenta
                if user[8]==0:
                    flash("El usuario no ha validado su cuenta")
                    return redirect(url_for("form_login"))
                # Si el usuario ha validado su cuenta
                else:   
                    session["nombre"] = nombre
                    session["roll"] = user[7]
                    #hashed_password = generate_password_hash(clave)
                    if session["roll"] == 3:
                        return redirect(url_for("admin_menu", user=user))
                    else:
                        return redirect(url_for("menu_user", user=user))
    # si no hay un post     
    else:
        return render_template("auth/form-login.html")
@app.route("/logout")
def logout():
    # Clear the session
    session.clear()
    return redirect("/")


# EVENTS
###################################################
def get_all_eventos_by_user(id):
    eventos=sqliteClient.get_all_eventos_by_user(id)
    return render_template("getAll.html", eventos=eventos)
@app.route("/events/getAll")
def eventsGetAll():
    if session["roll"] != 3:
        return redirect("/")
    else:
        eventos=sqliteClient.get_all_eventos()
        return render_template("events/getAll.html", eventos=eventos)


# USERS
###################################################
@app.route("/menu_user/<user>")
def menu_user(user):
    return render_template("user/menu_user.html", user=user)
@app.route("/users/getAll")
def userGetAll():
    if session["roll"] != 3:
        return redirect("/")
    else:
        usuarios=sqliteClient.get_all_usuarios()
        return render_template("users/getAll.html", usuarios=usuarios)
@app.route("/user/create",methods = ["POST"])
def crear_usurio():
    nombre = request.form.get("nombre")
    password = request.form.get("password")
    dni = request.form.get("dni")
    fecha_nacimiento = request.form.get("fecha_nacimiento")
    direccion = request.form.get("direccion")
    email = request.form.get("email")
    roll = request.form.get("roll")
    validate = request.form.get("validate")
    sqliteClient.crear_usuario(nombre,password,dni,fecha_nacimiento,direccion,email,roll,validate)
    return redirect("/")

@app.route("/user/form-edit",methods = ["POST"])
def form_edit():
    id = request.form.get("id")
    usuarios = sqliteClient.mostrar_usuario_por_id(id)
    if len(usuarios) == 0:
        return redirect("/")
    else:
        usuario=usuarios[0]
        return render_template("users/edit.html",usuario=usuario)

@app.route("/user/update",methods = ["POST"])
def modificar_usurio():
    id = request.form.get("id")
    nombre = request.form.get("nombre")
    apellidos = request.form.get("apellidos")
    fecha_nac = request.form.get("fecha_nac")
    sqliteClient.modificar_usuarios(nombre,apellidos,fecha_nac,id)
    return redirect("/")

@app.route("/user/delete",methods = ["POST"])
def borrar_usurio():
    id = request.form.get("id")
    f.borrar_usuario(conexion,id)
    return redirect("/")        




# ADMIN
###################################################
@app.route("/admin/menu/<user>")
def admin_menu(user):
    return render_template("admin/menu.html", user=user)
@app.route("/users/edit/<id_user>")
def user_edit(id_user):
    if session["roll"] != 3:
        return redirect("/")
    else:
        usuario=sqliteClient.get_issuer_by_id(id_user).fetchone()
        return render_template("users/edit.html", usuario)

    
# Start the Server
if __name__ == "__main__":
    #app.run(host="0.0.0.0", port=3000, debug=True)
    app.run(debug=True)