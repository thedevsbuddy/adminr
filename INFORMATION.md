# Please keep in mind

When using this project to generate and create your own project that this is mainly focused
on admin panel and Resources generate part only.

## WARNING
Currently, generated resources can not be modified by the `GUI` and if you need to 
customize it further then you are free to customize it from the generated folders but 
please keep in mind that some files from generated resources can not be modified 
or deleted as they are required to `run the app`. You can see the required files list below.

__Note__: Only some part of the resource can be modified from the `GUI` 
for example managing `permissions` for resource and `API` routes. 

### Required files (from `Resources`) for `Adminr` to work.

Below files and folders are required by the `adminr`.

#### In folders/directories
* _adminr_
* _Core_
  * _all directories inside Core_
* _Resources_
  * _< resource >_ - Eg: `Article`
    * _all directories_

#### In files

Inside `Resources` Directory
* `resources.json`

Files inside any `resource`
* `resource.json`
* Routes
  * `Routes/api.php`
  * `Routes/web.php`
* Views
  * `index.blade.php`
  * `create.blade.php`
  * `edit.blade.php`
* Middlewares (Required all files) - Don't modify anything manually.
  * `ResourceMiddleware.php`
  * `api.json`
  * `web.json`



