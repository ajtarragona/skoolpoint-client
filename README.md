# Mailrelay Laravel Client
Cliente Laravel de la API Rest de MailRelay.

*Credits*: Ajuntament de Tarragona.


> Check the MailRelay API docs here: [https://tarragona1.ipzmarketing.com/api-documentation/](https://tarragona1.ipzmarketing.com/api-documentation/)



<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Instalación](#instalacin)
- [Configuración](#configuraci%C3%B3n)
- [Uso](#uso)
  - [Funciones](#funciones)
    - [getSenders()](#getsenders)
    - [getSender($id)](#getsenderid)
    - [createSender($name, $email)](#createsendername-email)
    - [getCustomFields()](#getcustomfields)
    - [getCustomField($id)](#getcustomfieldid)
    - [createCustomField($name, $label, $type="text", $required=false, $default_value="", $options=[])](#createcustomfieldname-label-typetext-requiredfalse-default_value-options)
    - [getGroups()](#getgroups)
    - [getGroup($id)](#getgroupid)
    - [createGroup($name, $description=null)](#creategroupname-descriptionnull)
    - [getCampaigns()](#getcampaigns)
    - [getCampaign($id)](#getcampaignid)
    - [createCampaign($subject, $body, $sender_id, $group_ids=[], $target="groups", $attributes=[])](#createcampaignsubject-body-sender_id-group_ids-targetgroups-attributes)
  - [Clase RestModel](#clase-restmodel)
    - [delete()](#delete)
    - [update($attributes=[])](#updateattributes)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->


## Instalación
```bash
composer require ajtarragona/mailrelay-client
``` 

## Configuración
Puedes configurar el paquete a través del archivo `.env` de tu aplicación Laravel, a través de las siguientes variables de entorno:

```bash
MAILRELAY_API_URL
MAILRELAY_API_KEY
```

Alternativamente, puedes publicar en archivo de configuración a través del comando:

```bash
php artisan vendor:publish --tag=ajtarragona-mailrelay-config
```

Esto creará el archivo `mailrelay.php` en la carpeta `config` de tu aplicación Laravel.
 

## Uso
Puedes usar el servicio de tres maneras diferentes:

**A través de una `Facade`:**
```php
use MailRelay;
...
public  function  test(){
    $remitents=MailRelay::getSenders();
    ...
}
```

> *Nota*: Para Laravel < 5.6, es necesario registrar el alias de la `Facade` en el archivo `config/app.php` de tu aplicación Laravel
 ```php
'aliases'  =>  [
    ...
    'MailRelay'  =>  Ajtarragona\MailRelay\Facades\MailRelay::class
]
```

  

**Vía Inyección de dependencias:**

En tus controladores, helpers, modelo...

```php
use Ajtarragona\MailRelay\MailRelayService;
...

public  function  test(MailRelayService  $mailrelay){
    $remitents=$mailrelay->getSenders();
    ...
}
```

**Vía función `helper`:**

```php
...
public  function  test(){
    $remitents=mailrelay()->getSenders();
    ...
}
```

---

### Funciones

#### getSenders()
Retorna todos los remitentes. 

Un remitente es un objeto de la clase `Sender`, que hereda de la clase [RestModel](#clase-restmodel)
    
#### getSender($id)
Retorna un remitente
        
#### createSender($name, $email)
Añade un remitente

- `$name`: nombre del remitente 
- `$email`: email del remitente 
		
#### getCustomFields()
Retorna todos los custom_fields de Mailrelay.

Un custom_fields es un objeto de la clase `CustomField`, que hereda de la clase [RestModel](#clase-restmodel)
		
#### getCustomField($id)
Retorna un custom_fields
        

#### createCustomField($name, $label, $type="text", $required=false, $default_value="", $options=[])
Añade un custom field a mailrelay.

- `$name`: nombre corto interno
- `$label`: nombre visible
- `$type` : Tipo de campo. Soportados: text, textarea, number, select, select_multiple, checkbox, radio_buttons, date. (opcional, por defecto `text`) 
- `$required`: Indica si será obligatorio (opcional, por defecto `false`)
- `$default_value`: Valor por defecto (opcional)

En caso de ser select, select_multiple, checkbox o radio_buttons:
- `$options` es un array con los nombres de las opciones


#### getGroups()
Retorna todos los grupos.

Un grupo es un objeto de la clase `Group`, que hereda de la clase [RestModel](#clase-restmodel)

      
#### getGroup($id)
Retorna un grupo
      
      
#### createGroup($name, $description=null)
Añade un grupo
		
#### getCampaigns()
Retorna todos los boletines.

Un boletín es un objeto de la clase `Campaign`, que hereda de la clase [RestModel](#clase-restmodel)


#### getCampaign($id)
Retorna un boletin
       
#### createCampaign($subject, $body, $sender_id, $group_ids=[], $target="groups", $attributes=[])
Añade un boletin

- `$subject` Asunto
- `$body` Cuerpo del boletín
- `$sender_id`Id del remitente 
- `$group_ids`Array de Ids de grupo (opcional)
- `$target` Indica si serà un boletín de grupos (`groups`) o de segmento (`segment`)
- `$attributes` Array con otros atributos opcionales que pasaremos a la API MailRelay.




---

### Clase RestModel
Los objetos que devuelve la API se devuelven como instancias de la clase RestModel.

Sobre estos objetos podemos invocar los siguientes métodos:

#### delete()
Eliminará el objeto de MailRelay
```php
$sender=MailRelay::getSender($id);
$sender->delete();
```

#### update($attributes=[])
Modificará los atributos pasados
```php
$sender=MailRelay::getSender($id);
$sender->update([
    "name"=>"Nuevo nombre"
]);
```



