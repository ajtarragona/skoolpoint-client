# Mailrelay Laravel Client
Cliente Laravel de la API Rest de MailRelay.

*Credits*: Ajuntament de Tarragona.


> Check the MailRelay API docs here: [https://tarragona1.ipzmarketing.com/api-documentation/](https://tarragona1.ipzmarketing.com/api-documentation/)



<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Instalación](#instalaci%C3%B3n)
- [Configuración](#configuraci%C3%B3n)
- [Uso](#uso)
  - [Funciones](#funciones)
    - [getSenders($page=null, $per_page=null)](#getsenderspagenull-per_pagenull)
    - [getSender($id)](#getsenderid)
    - [getDefaultSender()](#getdefaultsender)
    - [createSender($name, $email)](#createsendername-email)
    - [getCustomFields($page=null, $per_page=null)](#getcustomfieldspagenull-per_pagenull)
    - [getCustomField($id)](#getcustomfieldid)
    - [createCustomField($name, $label, $type="text", $required=false, $default_value="", $options=[])](#createcustomfieldname-label-typetext-requiredfalse-default_value-options)
    - [getGroups($page=null, $per_page=null)](#getgroupspagenull-per_pagenull)
    - [getGroup($id)](#getgroupid)
    - [createGroup($name, $description=null)](#creategroupname-descriptionnull)
    - [getCampaigns($page=null, $per_page=null)](#getcampaignspagenull-per_pagenull)
    - [getCampaign($id)](#getcampaignid)
    - [createCampaign($subject, $body, $sender_id, $group_ids=[], $target="groups", $attributes=[])](#createcampaignsubject-body-sender_id-group_ids-targetgroups-attributes)
    - [getCampaignFolders($page=null, $per_page=null)](#getcampaignfolderspagenull-per_pagenull)
    - [getCampaignFolder($id)](#getcampaignfolderid)
    - [createCampaignFolder($name)](#createcampaignfoldername)
    - [getImports($page=null, $per_page=null)](#getimportspagenull-per_pagenull)
    - [getImport($id)](#getimportid)
    - [createImport($filename, $subscribers, $group_ids=[], $callback=null, $ignore=true)](#createimportfilename-subscribers-group_ids-callbacknull-ignoretrue)
    - [getMediaFiles($page=null, $per_page=null){](#getmediafilespagenull-per_pagenull)
    - [getMediaFile($id){](#getmediafileid)
    - [createMediaFile($filename, $content, $media_folder_id=false){](#createmediafilefilename-content-media_folder_idfalse)
    - [uploadMediaFile($filename, $uploaded_file, $media_folder_id=0){](#uploadmediafilefilename-uploaded_file-media_folder_id0)
    - [getMediaFolders(){](#getmediafolders)
    - [getMediaFolder($id){](#getmediafolderid)
    - [createMediaFolder($name){](#createmediafoldername)
  - [Clases](#clases)
    - [Clase RestModel](#clase-restmodel)
      - [delete()](#delete)
      - [update($attributes=[])](#updateattributes)
    - [Clase Sender](#clase-sender)
      - [sendConfirmationMail()](#sendconfirmationmail)
    - [Clase Campaign](#clase-campaign)
      - [send()](#send)
    - [Clase Import](#clase-import)
      - [data()](#data)
      - [cancel()](#cancel)

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
MAILRELAY_DEBUG
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

#### getSenders($page=null, $per_page=null)
Retorna todos los remitentes. 

- `$page`: numero de pàgina (opcional)
- `$per_page`: registres per pàgina (opcional)
	
Un remitente es un objeto de la clase [Sender](#clase-sender)
    
#### getSender($id)
Retorna un remitente
    
#### getDefaultSender()
Retorna el remitente por defecto
         
#### createSender($name, $email)
Añade un remitente

- `$name`: nombre del remitente 
- `$email`: email del remitente 
		
#### getCustomFields($page=null, $per_page=null)
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


#### getGroups($page=null, $per_page=null)
Retorna todos los grupos.

Un grupo es un objeto de la clase `Group`, que hereda de la clase [RestModel](#clase-restmodel)

      
#### getGroup($id)
Retorna un grupo
      
      
#### createGroup($name, $description=null)
Añade un grupo
		
#### getCampaigns($page=null, $per_page=null)
Retorna todos los boletines.

Un boletín es un objeto de la clase [Campaign](#clase-campaign)


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


		
#### getCampaignFolders($page=null, $per_page=null)
Retorna todas las carpetas de boletín.

#### getCampaignFolder($id)
Retorna una carpeta de boletín
       
#### createCampaignFolder($name)
Añade una carpeta de boletín

- `$name` Nombre de la carpeta


		
#### getImports($page=null, $per_page=null)
Retorna todas las importaciones.

Una importacion es un objeto de la clase [Import](#clase-import)


#### getImport($id)
Retorna una importacion
       
#### createImport($filename, $subscribers, $group_ids=[], $callback=null, $ignore=true)
Añade una importacion

- `$filename`     name of the file created in MailRelay
- `$subscribers`  must be an array of subscribers. Each row must have the same key=>value fields. Custom fields key shold be: `custom_field_ID`
- `$group_ids`    array of group IDs the users will be subscribed to
- `$callback`     url
- `$ignore`       by default existing users will be ignored


```php
MailRelay::createImport("prueba api",[
  [
    "name"=>"juan",
    "email"=>"juan2@txomin.com",
    "custom_field_17"=>"a"
  ],
  [
    "name"=>"Luis d'Àvila",
    "email"=>"luis2@txomin.com",
    "custom_field_17"=>"bb"
  ]
],[13]);

```



####  getMediaFiles($page=null, $per_page=null){
Retorna todas las imagenes  
  
####  getMediaFile($id){
Retorna una imagen
  

####  createMediaFile($filename, $content, $media_folder_id=false){
Añade una imagen
- `$filename`   Nombre de la imagen
- `$content`    Contenido biario de la imagen (no base64)
    
    
####  uploadMediaFile($filename, $uploaded_file, $media_folder_id=0){
Añade una imagen a partir de un upload
  
####  getMediaFolders(){
Retorna las carpetas de media
    
####  getMediaFolder($id){
Retorna una carpeta de media
      
####  createMediaFolder($name){
Añade una carpeta de media.

Si ya existe con el mismo nombre, la devuelve
       

---

### Clases

#### Clase RestModel
Los objetos que devuelve la API se devuelven como instancias de la clase RestModel.

Sobre estos objetos podemos invocar los siguientes métodos:

##### delete()
Eliminará el objeto de MailRelay
```php
$sender=MailRelay::getSender(2);
$sender->delete();
```

##### update($attributes=[])
Modificará los atributos pasados
```php
$sender=MailRelay::getSender(2);
$sender->update([
    "name"=>"Nuevo nombre"
]);
```


#### Clase Sender
Hereda de la clase [RestModel](#clase-restmodel)

Métodos:
##### sendConfirmationMail()
Envía el mail de confirmación al remitente
```php
$sender=MailRelay::getSender(2);
$sender->sendConfirmationMail();
```




#### Clase Campaign
Hereda de la clase [RestModel](#clase-restmodel)

Métodos:
##### send()
Envía el boletín
```php
$boletin=MailRelay::getCampaign(5);
$boletin->send();
```



#### Clase Import
Hereda de la clase [RestModel](#clase-restmodel)

Métodos:
##### data()
Devuelve los datos de la importación

##### cancel()
Cancela una importación si está en curso


