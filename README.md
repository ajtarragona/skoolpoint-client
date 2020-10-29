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
    - [Senders (Remitentes)](#senders-remitentes)
      - [getSenders($page=null, $per_page=null)](#getsenderspagenull-per_pagenull)
      - [getSender($id)](#getsenderid)
      - [getDefaultSender()](#getdefaultsender)
      - [createSender($name, $email)](#createsendername-email)
    - [Custom Fields](#custom-fields)
      - [getCustomFields($page=null, $per_page=null)](#getcustomfieldspagenull-per_pagenull)
      - [getCustomField($id)](#getcustomfieldid)
      - [createCustomField($name, $label, $type="text", $required=false, $default_value="", $options=[])](#createcustomfieldname-label-typetext-requiredfalse-default_value-options)
    - [Groups](#groups)
      - [getGroups($page=null, $per_page=null)](#getgroupspagenull-per_pagenull)
      - [getGroup($id)](#getgroupid)
      - [createGroup($name, $description=null)](#creategroupname-descriptionnull)
    - [Campaigns (Boletines)](#campaigns-boletines)
      - [getCampaigns($page=null, $per_page=null)](#getcampaignspagenull-per_pagenull)
      - [getCampaign($id)](#getcampaignid)
      - [createCampaign($subject, $body, $sender_id, $group_ids=[], $target="groups", $attributes=[])](#createcampaignsubject-body-sender_id-group_ids-targetgroups-attributes)
    - [Sent Campaigns (Informes de envio de Boletines)](#sent-campaigns-informes-de-envio-de-boletines)
      - [getSentCampaigns($page=null, $per_page=null)](#getsentcampaignspagenull-per_pagenull)
      - [getSentCampaign($id)](#getsentcampaignid)
    - [Campaign Folders](#campaign-folders)
      - [getCampaignFolders($page=null, $per_page=null)](#getcampaignfolderspagenull-per_pagenull)
      - [getCampaignFolder($id)](#getcampaignfolderid)
      - [createCampaignFolder($name)](#createcampaignfoldername)
    - [Imports](#imports)
      - [getImports($page=null, $per_page=null)](#getimportspagenull-per_pagenull)
      - [getImport($id)](#getimportid)
      - [createImport($filename, $subscribers, $group_ids=[], $callback=null, $ignore=true)](#createimportfilename-subscribers-group_ids-callbacknull-ignoretrue)
    - [Media Files](#media-files)
      - [getMediaFiles($page=null, $per_page=null)](#getmediafilespagenull-per_pagenull)
      - [getMediaFile($id){](#getmediafileid)
      - [createMediaFile($filename, $content, $media_folder_id=false)](#createmediafilefilename-content-media_folder_idfalse)
      - [uploadMediaFile($filename, $uploaded_file, $media_folder_id=0)](#uploadmediafilefilename-uploaded_file-media_folder_id0)
    - [Media Folders](#media-folders)
      - [getMediaFolders(){](#getmediafolders)
      - [getMediaFolder($id){](#getmediafolderid)
      - [createMediaFolder($name){](#createmediafoldername)
  - [Clases](#clases)
    - [Clase RestModel](#clase-restmodel)
      - [delete()](#delete)
      - [update($attributes=[])](#updateattributes)
    - [Clase CustomField](#clase-customfield)
    - [Clase Sender](#clase-sender)
      - [sendConfirmationMail()](#sendconfirmationmail)
    - [Clase Group](#clase-group)
    - [Clase Campaign](#clase-campaign)
      - [send()](#send)
    - [Clase SentCampaign](#clase-sentcampaign)
      - [clicks()](#clicks)
      - [impressions()](#impressions)
      - [sent_emails()](#sent_emails)
      - [unsubscribe_events()](#unsubscribe_events)
    - [Clase CampaignFolder](#clase-campaignfolder)
    - [Clase Import](#clase-import)
      - [data()](#data)
      - [cancel()](#cancel)
    - [Clase MediaFile](#clase-mediafile)
    - [Clase MediaFolder](#clase-mediafolder)

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

#### Senders (Remitentes)
Un remitente es un objeto de la clase [Sender](#clase-sender)

##### getSenders($page=null, $per_page=null)
Retorna todos los remitentes. 

- `$page`: numero de pàgina (opcional)
- `$per_page`: registres per pàgina (opcional)
	
    
##### getSender($id)
Retorna un remitente
    
##### getDefaultSender()
Retorna el remitente por defecto
         
##### createSender($name, $email)
Añade un remitente

- `$name`: nombre del remitente 
- `$email`: email del remitente 





#### Custom Fields
Un custom field es un objeto de la clase [CustomField](#clase-customfield)

##### getCustomFields($page=null, $per_page=null)
Retorna todos los custom_fields de Mailrelay.

		
##### getCustomField($id)
Retorna un custom_fields
        

##### createCustomField($name, $label, $type="text", $required=false, $default_value="", $options=[])
Añade un custom field a mailrelay.

- `$name`: nombre corto interno
- `$label`: nombre visible
- `$type` : Tipo de campo. Soportados: text, textarea, number, select, select_multiple, checkbox, radio_buttons, date. (opcional, por defecto `text`) 
- `$required`: Indica si será obligatorio (opcional, por defecto `false`)
- `$default_value`: Valor por defecto (opcional)

En caso de ser select, select_multiple, checkbox o radio_buttons:
- `$options` es un array con los nombres de las opciones





#### Groups
Un grupo es un objeto de la clase [Group](#clase-group)

##### getGroups($page=null, $per_page=null)
Retorna todos los grupos.

      
##### getGroup($id)
Retorna un grupo
      
      
##### createGroup($name, $description=null)
Añade un grupo
		





#### Campaigns (Boletines)
Un boletín es un objeto de la clase [Campaign](#clase-campaign)


##### getCampaigns($page=null, $per_page=null)
Retorna todos los boletines.



##### getCampaign($id)
Retorna un boletin
       
##### createCampaign($subject, $body, $sender_id, $group_ids=[], $target="groups", $attributes=[])
Añade un boletin

- `$subject` Asunto
- `$body` Cuerpo del boletín
- `$sender_id`Id del remitente 
- `$group_ids`Array de Ids de grupo (opcional)
- `$target` Indica si serà un boletín de grupos (`groups`) o de segmento (`segment`)
- `$attributes` Array con otros atributos opcionales que pasaremos a la API MailRelay.





#### Sent Campaigns (Informes de envio de Boletines)
Un informe de envio de boletín es un objeto de la clase [SentCampaign](#clase-sentcampaign)


##### getSentCampaigns($page=null, $per_page=null)
Retorna todos los informes de envio de boletín.


##### getSentCampaign($id)
Retorna un informe de envio de boletín


#### Campaign Folders
Una carpeta es un objeto de la clase [CampaignFolder](#clase-campaignfolder)

##### getCampaignFolders($page=null, $per_page=null)
Retorna todas las carpetas de boletín.

##### getCampaignFolder($id)
Retorna una carpeta de boletín
       
##### createCampaignFolder($name)
Añade una carpeta de boletín

- `$name` Nombre de la carpeta







#### Imports
Una importacion es un objeto de la clase [Import](#clase-import)

##### getImports($page=null, $per_page=null)
Retorna todas las importaciones.



##### getImport($id)
Retorna una importacion
       
##### createImport($filename, $subscribers, $group_ids=[], $callback=null, $ignore=true)
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






#### Media Files
Un media file es un objeto de la clase [MediaFile](#clase-mediafile)

#####  getMediaFiles($page=null, $per_page=null)
Retorna todas las imagenes  
  
#####  getMediaFile($id){
Retorna una imagen
  

#####  createMediaFile($filename, $content, $media_folder_id=false)
Añade una imagen
- `$filename`   Nombre de la imagen
- `$content`    Contenido biario de la imagen (no base64)
    

#####  uploadMediaFile($filename, $uploaded_file, $media_folder_id=0)
Añade una imagen a partir de un upload







#### Media Folders
Un media folder es un objeto de la clase [MediaFolder](#clase-mediafolder)

#####  getMediaFolders(){
Retorna las carpetas de media
    
#####  getMediaFolder($id){
Retorna una carpeta de media
      
#####  createMediaFolder($name){
Añade una carpeta de media.

Si ya existe con el mismo nombre, la devuelve
       

---

### Clases

#### Clase RestModel
Los objetos que devuelve la API se devuelven como instancias de la clase `RestModel`.
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


#### Clase CustomField
Hereda de la clase [RestModel](#clase-restmodel)


#### Clase Sender
Hereda de la clase [RestModel](#clase-restmodel)

Métodos:
##### sendConfirmationMail()
Envía el mail de confirmación al remitente
```php
$sender=MailRelay::getSender(2);
$sender->sendConfirmationMail();
```


#### Clase Group
Hereda de la clase [RestModel](#clase-restmodel)



#### Clase Campaign
Hereda de la clase [RestModel](#clase-restmodel)

Métodos:
##### send()
Envía el boletín
```php
$boletin=MailRelay::getCampaign(5);
$boletin->send();
```

#### Clase SentCampaign
Hereda de la clase [RestModel](#clase-restmodel)

Métodos:
##### clicks()
Retona els clicks
##### impressions()
Retona les impressions
##### sent_emails()
Retona els emails enviats
##### unsubscribe_events()
Retona les desubscripcions

#### Clase CampaignFolder
Hereda de la clase [RestModel](#clase-restmodel)


#### Clase Import
Hereda de la clase [RestModel](#clase-restmodel)

Métodos:
##### data()
Devuelve los datos de la importación

##### cancel()
Cancela una importación si está en curso


#### Clase MediaFile
Hereda de la clase [RestModel](#clase-restmodel)


#### Clase MediaFolder
Hereda de la clase [RestModel](#clase-restmodel)

