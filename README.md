# Skoolpoint Laravel Client
Cliente Laravel de la API Rest de Skoolpoint.

*Credits*: Ajuntament de Tarragona.

> Check the Skoolpoint API docs here: [https://preinscripcions.skoolpoint.com/api/](https://preinscripcions.skoolpoint.com/api/)



<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

<!-- END doctoc generated TOC please keep comment here to allow auto update -->


## Instalación
```bash
composer require ajtarragona/skoolpoint-client
``` 

## Configuración
Puedes configurar el paquete a través del archivo `.env` de tu aplicación Laravel, a través de las siguientes variables de entorno:

```bash
SKOOLPOINT_API_URL
SKOOLPOINT_API_USER
SKOOLPOINT_API_TOKEN
SKOOLPOINT_API_PASSWORD
SKOOLPOINT_DEBUG
```

Si no definimos el API_TOKEN, se utilizará el usuario/password en cada llamada a la API.

Alternativamente, puedes publicar en archivo de configuración a través del comando:

```bash
php artisan vendor:publish --tag=ajtarragona-skoolpoint-config
```

Esto creará el archivo `skoolpoint.php` en la carpeta `config` de tu aplicación Laravel.
 

## Uso
Puedes usar el servicio de tres maneras diferentes:

**A través de una `Facade`:**
```php
use Skoolpoint;
...
public  function  test(){
    $centers=Skoolpoint::getCenters();
    ...
}
```

> *Nota*: Para Laravel < 5.6, es necesario registrar el alias de la `Facade` en el archivo `config/app.php` de tu aplicación Laravel
 ```php
'aliases'  =>  [
    ...
    'Skoolpoint'  =>  Ajtarragona\Skoolpoint\Facades\Skoolpoint::class
]
```

  

**Vía Inyección de dependencias:**

En tus controladores, helpers, modelo...

```php
use Ajtarragona\Skoolpoint\SkoolpointService;
...

public  function  test(SkoolpointService  $skoolpoint){
    $centers=$skoolpoint->getCenters();
    ...
}
```

**Vía función `helper`:**

```php
...
public  function  test(){
    $centers=skoolpoint()->getCenters();
    ...
}
```


---

### Funciones


##### getCenters($options=[])
Retorna todos los Centros. 
Options és un array con los posibles valores:
- `pagina`: numero de pàgina (opcional)
- `limit`: registres per pàgina (opcional)


##### getCenter($codi_centre)
Retorna un centro a partir de su código. 

##### searchCenters($term, $options=[])
Retorna centros que contengan el texto `$term`. 

##### getOfertaCenter($codi_centre)
Retorna la oferta de un centro.

##### getSolicituds($codi_centre, $state_name, $options=[])
Retorna solicitudes de un centro en un estado pasado
`state_name`puede tener los valores:
- registrades
- validades
- pendents/reclamacioBarem
- pendents/reclamacioAssignacio
- pendents/assignacio
- pendents/matricula
- llistaEspera
- assignades
- noAssignades
- tancades
- matriculades

##### getSolicitudsRegistrades($codi_centre, $options=[])
Retorna solicitudes de un centro Registradas
Options és un array con los posibles valores:
- `pagina`: numero de pàgina (opcional)
- `limit`: registres per pàgina (opcional)
- `tutors`: boolea (opcional)
- `nese`: boolea (opcional)


##### getSolicitudsValidades($codi_centre, $options=[])
Retorna solicitudes de un centro Validadas

##### getSolicitudsPendentsReclamacioBarem($codi_centre, $options=[])
Retorna solicitudes de un centro Pendientes de reclamación baremo

##### getSolicitudsPendentsReclamacioAssignacio($codi_centre, $options=[])
Retorna solicitudes de un centro Pendientes de Reclamación asignación

##### getSolicitudsPendentsAssignacio($codi_centre, $options=[])
Retorna solicitudes de un centro Pendientes de asignación

##### getSolicitudsPendentsMatricula($codi_centre, $options=[])
Retorna solicitudes de un centro Pendientes de matricula

##### getSolicitudsLlistaEspera($codi_centre, $options=[])
Retorna solicitudes de un centro en Lista de espera

##### getSolicitudsAssignades($codi_centre, $options=[])
Retorna solicitudes de un centro Asignadas

##### getSolicitudsNoAssignades($codi_centre, $options=[])
Retorna solicitudes de un centro No asignadas

##### getSolicitudsTancades($codi_centre, $options=[])
Retorna solicitudes de un centro Cerradas

##### getSolicitudsMatriculades($codi_centre, $options=[])
Retorna solicitudes de un centro Matriculadas
