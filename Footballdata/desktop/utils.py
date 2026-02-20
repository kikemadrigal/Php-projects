def texto_a_binario(archivo_texto, archivo_binario):
    # Leer el archivo de texto
    with open(archivo_texto, 'r') as f_texto:
        contenido = f_texto.read()
    
    # Convertir el contenido de texto a bytes
    contenido_binario = contenido.encode('utf-8')
    
    # Escribir el contenido en un archivo binario
    with open(archivo_binario, 'wb') as f_binario:
        f_binario.write(contenido_binario)

def binario_a_texto(archivo_binario, archivo_texto):
    # Leer el contenido del archivo binario
    with open(archivo_binario, 'rb') as f_binario:
        contenido_binario = f_binario.read()
    
    # Decodificar los bytes a texto (UTF-8)
    contenido_texto = contenido_binario.decode('utf-8')
    
    # Escribir el contenido de texto en un nuevo archivo de texto
    with open(archivo_texto, 'w') as f_texto:
        f_texto.write(contenido_texto)
def binario_a_json(archivo_binario):
    # Leer el contenido del archivo binario
    with open(archivo_binario, 'rb') as f_binario:
        contenido_binario = f_binario.read()
    
    # Decodificar los bytes a texto (UTF-8)
    contenido_texto = contenido_binario.decode('utf-8')
    
    return contenido_texto
#texto_a_binario('credentials.json', 'credentials.bin')




