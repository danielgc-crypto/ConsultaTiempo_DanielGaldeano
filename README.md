# ConslutaTiempo_DanielGaldeano

# Índice
1. [Introducción](#id1)
2. [Objetivo](#id2)
3. [Creación de la instancia EC2](#id3)  
  3.1 [Instalaciones dentro de la instancia](#3.1)
4.  




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

El despliegue se hará desde una instancia EC2 en AWS **(Amazon Web Services)** y se accederá desde una IP pública que se asignará automáticamente, el problema de esto que tanto para conectarse por ssh o acceder a la aplicación hay que vigilar que la dirección IP no haya cambiado.  

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







