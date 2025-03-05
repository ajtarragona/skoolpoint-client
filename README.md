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
SKOOLPOINT_API_PASSWORD
SKOOLPOINT_DEBUG
```

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

#### Senders (Remitentes)
Un remitente es un objeto de la clase [Sender](#clase-sender)

##### getSenders($page=null, $per_page=null)
Retorna todos los remitentes. 

- `$page`: numero de pàgina (opcional)
- `$per_page`: registres per pàgina (opcional)
	
    
---

### Clases

#### Clase Center
Los objetos que devuelve la API se devuelven como instancias de la clase `RestModel`.
Sobre estos objetos podemos invocar los siguientes métodos:
