        ````````````         .    `....`                                                            
     `...````````  ``.`      .   .-`  `.``....  ....` `...`  `.``...` `....  ....                   
   .. .///////::::-.` `.`    .  `-.      -.  .-.-` .-.-` `-.-.``-.`.-..-.`.`-.  .-                  
 `.`  .-:::://////////  `.   .   .-`  `.`-.  --.-  .-.-` `-.-. `-.``.``.`.-.-.  .-                  
 .   ..... .///-`.-:::`  `.  .    `....`  ...` `.  `.``...-..`  `...` `....  ....                   
.`  `....  :///`          .` .   -:///::             `.-.-.                                :-       
-   `.... .///:           `. .     .+-   -//.:::/-./::/../::/.`:/:/-`-/:/:`-:/.:/:/-`-/:/:`//../:::.
-   `.... -///.           `. .     .+-  -+. `---////  //-/::-.:/  .+-.--:+:+- :+:-:+:+- `+://`+/--//
.`   ....`///:    `...`   .` .     .+-  :+` :/../://  //-:.-///+-.:+-+-`:+:+. .+-.-:.+- `+://.//..:.
 .`  `...-::/-  `.....   .`  .     `-`  ..  `.--. ..  ..`.--. //.--` .--.``-`  `.-.``-`  .`.-. .--. 
  .`  `..::::-......`   .`   .     .---. `.-.`---.`           --                                    
   `.`  `----....``  `..     .    .:` .:.:-`.:. `:-                                                 
      `.``       ```.`       .    .:. .:.:. `:. `:-                                                 
         `````````           `   .``...``.`  `...:-                                                 
                                             .----`                                                 


Última revisión de este documento: 24-ENE-2016
=====================================================================================================
REQUERIMIENTOS
=====================================================================================================
1. Apache 2.2 con mod_rewrite.
2. PHP 5.5+
3. Mysql Community Server 5.5+

=====================================================================================================
INSTALACIÓN
=====================================================================================================
1. Asegurarse que todos los archivos en /website estén en la carpeta web de Apache.
2. Ejecutar el último archivo de instrucciones de MySQL ubicado en /database. Estos tienen el formato
   MO-CO-YYYY-MM-DD-structure.sql para la estructura de base de datos y MO-CO-YYYY-MM-DD-data.sql para
   los datos, por lo que se debe usar el de la fecha más reciente.
3. Copiar el archivo en /conf_files/application/config/config.php a website/application/config y cambiar 
   el valor de <URL> por el URL raíz sin el protocolo (por ejemplo: misitio.com y no http://misitio.com). 
   NOTA: El URL debe acabar con diagonal (/).
4. Copiar el archivo en /conf_files/application/config/database.php a /website/application/config/ y 
   cambiar los valores de <DB SERVER>, <DB USER>, <DB PASSWORD> y <DB DATABASE> por los valores de 
   conexión de la base de datos. 
5. Copiar el archivo en /conf_files/.htaccess a /website/. NOTA: Este es un archivo de configuración de
   Apache necesario para generar URLs amigables. Es posible que se deba ajustar dependiendo de la 
   configuración del servidor.
6. Ir a /website desde el navegador para acceder al sitio público. Si carga el sitio, ¡felicitaciones! 
   la instalación fue realizada con éxito.


=====================================================================================================
NOTAS ADICIONALES
=====================================================================================================
+ La organización del proyecto es la siguiente:
  + /conf_files: Archivos de configuración.
  + /database: Archivos de instrucciones para la base de datos.
  + /website: Archivos de PHP, CSS y JS necesarios para la aplicación web.
+ Si la aplicación se está instalando en la web (por ejemplo para pruebas o producción), se 
  recomienda sólo copiar los archivos en /website y sustituir los archivos en /conf_files con los 
  valores indicados. No subir las demás carpetas como la de /database.
+ La consola administrativa se puede acceder agregando admin al URL del sitio (por ejemplo: 
  http://misitio.com/admin)
+ El usuario administrativo es "admin@donaldleiva.com" y la contraseña "admin"
+ El sitio está hecho con CodeIgniter 2. La guía de referencia está en 
  http://www.codeigniter.com/userguide2/.