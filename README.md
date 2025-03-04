# ConslutaTiempo_DanielGaldeano

# Índice
1. [Introducción](#id1)
2. [Objetivo](#id2)
3. [Creación de la instancia EC2](#id3)  
  3.1 [Instalaciones dentro de la instancia](#3.1)  
  3.2 [Configuraciones de apache](#3.2)
4. [Accediendo a la aplicación](#id4) 




## INTRODUCCIÓN<a name="id1"></a>

## Objetivo<a name="id2"></a>
El propósito de la práctica es desplegar en AWS una apliación web que permita consultar el tiempo de todas las ciudades del mundo.
La página debe mostrar lo siguiente:
* Formulario que permita la búsqueda de una ciudad.
  * Si no existe se informará en la página.
* Si existe:
  * Información meteorológica actual.
  * Previsión meteorológica del día.
  * Previsión meteorológica de la semana.


 ## Creación de la instancia EC2<a name="id3"></a>

El despliegue se hará desde una instancia EC2 en AWS **(Amazon Web Services)** y se accederá desde una IP pública que se asignará automáticamente, aunque más adelante asignaré una IP elástica para poder acceder por **URL**.  

**Nota: Como ya he hecho despligues documentados anteriormente no voy a centrarme mucho en explicar esta parte. 
El objetivo de la práctica se centra más en la aplicación que en el propio despliegue por lo que la configuración de la instancia y su seguridad no serán los adecuados en un entorno real.**  

**Una vez ya en la consola de AWS >> EC2 >> Lanzar una instancia**

* Primero, definir sistema operativo.
![image](https://github.com/user-attachments/assets/d30e0e14-dfce-4cdd-a256-32e71711469f)

* Segundo, definir tipo de instancia y crear un par de claves **(en mi caso uno ya hecho por AWS)** para conectarse por ssh.
![image](https://github.com/user-attachments/assets/bc33efa4-ee28-47b8-9db9-de86ad1484af)  

* Tercero, lo único necesario en las configuraciones de red es que asigne automáticamente una IP pública, lo demás se puede quedar por defecto y en el grupo de seguridad permitir el tráfico **HTTP**.
![image](https://github.com/user-attachments/assets/6fa1c1f1-7048-4a50-88aa-e681cdff03b6)
![image](https://github.com/user-attachments/assets/ea2a19c5-5097-400e-a636-c2bf01f64d0e)

En la consola de **instancias** ya se puede apreciar la instancia recién creada con su ip pública.

![image](https://github.com/user-attachments/assets/30f00ce8-0049-43e1-9a80-1c2c63b1cb51)

### Instalaciones dentro de la instancia <a name="3.1"></a>

Hay que hacer ciertas instalaciones para poder visualizar la aplicación e interactuar con ella, para resolver el problema he ejecutado un script que instale Apache y PHP. Dicho Script lo he pasado por scp desde mi máquina anfitriona.
![image](https://github.com/user-attachments/assets/4b946a27-5ef4-456a-9895-617947e1b27c)

**SCRIPT**  
Hay que darle permisos de ejecución `sudo chmod +x web.sh` y después ejecutarlo con `sudo bash web.sh`.
![image](https://github.com/user-attachments/assets/c2a88350-9587-49c4-b32f-260c16b25d38)


### Configuraciones de apache <a name="3.2"></a>

Para configurar apache solo hay que modificar la ruta del archivo default y poner en la que están alojados los archivos. Después de poner la ruta hay que reiniciar apache.  
`sudo systemctl reload apache2`,`sudo systemctl restart apache2`

![image](https://github.com/user-attachments/assets/71428a32-5453-461e-9cd8-f499f78daaf3)


## Accediendo a la aplicación <a name="id4"></a>

Para acceder a la aplicación he asignado una IP elástica a la instancia para poder darle un nombre de host y acceder por URL a la aplicación. 
URL DE ACCESO: http://tiempoentuciudad.servebeer.com/  

Una vez dentro se mostrará un formulario como el siguiente, pero sin ninguna ciudad.
![image](https://github.com/user-attachments/assets/0dffdae1-77f4-4dd8-9934-b6c10ac20dda)

Entonces al darle buscar te mostrará el tiempo de la ciudad introducida. 
![image](https://github.com/user-attachments/assets/0e156425-a246-4917-8858-5fca90e3c926)


Al darle a buscar puedes acceder por:
- Previsión por horas
![image](https://github.com/user-attachments/assets/5301be3f-5ff9-4d89-925e-459a8dcc6853)

- Previsión de la semana
![image](https://github.com/user-attachments/assets/7991a70c-4aa8-48aa-aa0b-d67e372dfc5a)

