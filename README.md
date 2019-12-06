# apace
Apace is an easy to use and fully featured open source PHP MVC built to help you write nicer and faster code, in a very simple way.


![alt tag](https://cloud.githubusercontent.com/assets/26118796/23610373/81414338-0272-11e7-9501-4aeea0410dbe.png)


### Main features:
- One core multiple applications structure thanks to internal domainmapping
- View template engine - you can have multiple master layouts
- Automatic HTML-compression for performance enhancement
- Page caching
- Multilanguage applications as default, no setup required
- Go from local to live development easy with the built in development status configuration
- A CLI which monitors your framework when you work and compile and minify your css and javascript files for you automatically.


![alt tag](https://cloud.githubusercontent.com/assets/26118796/23684726/d871b6fe-03a0-11e7-8500-759ef5443f1b.png)


*Apace is built to expand automatically with __one core__ and __multiple apps__.
This means that you can have all your applications in the same framework which simplifies upgrading your applications and the framework itself, sharing sessions between multiple applications and likewise sharing data between multiple applications.*

### How?
The answer is internal domainmapping, which can be set up with one line in the configuration file.

Domain mapping works with both domains and sub-domains, in plain text it transforms to this:
```
Apace /
|----- application /
|           |-------- admin        <=    http://mysite.com/admin/
|           |-------- app          <=    http://mysite.com/
|           |-------- anotherapp   <=    http://anothersite.com/ 
|----- data    /
|----- engine /
```

## 1. Getting started - Installation

1. Download the framework and put it in your desired folder.

2. Add a virtual host called apace.local from your localhost, point DocumentRoot to "c:/wamp/www/apace" and Directory to "c:/wamp/www/apace/". Don’t forget to update your computers hosts file. If you don’t know how to set up  a virtual host on localhost watch this tutorial: https://www.youtube.com/watch?v=WC8H8sAJLrQ . The framework will not work without a virtual host.

3.	In the Apace framework, go to application/app/configuration/config.ini, open the file and set set ```baseurl = http://apace.local/``` . 

## 2. Domain mapping

In Apace MVC you have the ability to create as many applications as you wish in the ‘application’ folder. This means that when you update the Apace framework, you only have to update it in one place, and all your applications will be updated since they use the same core of Apace framework.

It is possible to easily map multiple domains like ```www.mysite.com``` to one of your applications in the framework itself. It is also possible to map subdomains like ```www.mysite.com/admin``` or ```www.anothersite.com/admintwo``` to another app.

**Let’s do that now:**

1.	In your Apace folder, open engine/settings/local.ini and under [domainmapping] add ```http://apace.local/ = "app"```. 

This will tell the framework to load “app” when browsing ```http://apace.local/``` . It works dynamically without the need of further configuration.
Now visit ```http://apace.local/``` in your browser and you will see the default Apace index view.

That’s it, now you’re ready to start developing.

You can read more below or check out the Hello World tutorial here: https://github.com/apacedev/apace/blob/master/TUTORIAL.md

## 3. The Apace framework

### 3.1 Environment

**Deployment status**

Open engine/settings/deployment.ini to change deployment status to either local or live. Default deployment status is local. Apace will load the correct config file automatically according to your deployment status variable.


### 3.2 View engine template

- By default you have one master layout for all your views, and this layout can easily be swithed to another. It is possible to have multiple master layouts. By default layout.php is the view template which embed all other views.

### 3.3 Performance

- All HTML files served by Apace are automatically minified and compressed for faster loading time.
-	To speed up performance even more, you can cache views from inside a specific controller action by simply typing $this->enableCache(true) inside a controller action. 
-	Caching takes the current language into consideration. 
-	Cache is disabled by default.

### 3.4 Typing rules

- Classes in Controllers and Models must be typed in CamelCase, e.g. IndexController.
- All methods/functions in Controllers and Models must be written in lowercase, e.g. getdata().

### 3.5 Models, Views, Controllers

**Models** | Location: application/appname/model/MyModel.php
- Models which belongs to controllers are named the same name as the controller but ends with Model. E.g. a model for ‘IndexController’ would be named ‘IndexModel’. The filename of a model is always the same as the classname.

**Controllers** | Location: application/appname/controller/MyController.php
- A controllers filename is always the same as the classname. When calling a controller class via url use the controllers name without the ‘Controller’ prefix at the end of the class.

**Views** | Location: application/appname/view/view.php
- A view for e.g. method ‘index’ in ‘IndexController’ is automatically mapped to ‘view/index/index.php’. Views are .php files which contains normal html code with one Exception: Never use a closing </body> or </html> tag at the end of your layout views as these are automatically generated by the framework when rendering the view.

### 3.6 Assets structure

- Assets (css, javascript, images) are located in ‘data/appnamedata/’. E.g an application named ‘app’ will have it’s assets inside ‘data/appdata/’.

- Each asset folder consists of one css folder, one javascript folder and one img folder. The css and javascript folders contains subfolders named ‘lib’ and ‘minified’. Put all libraries (e.g bootstrap) in the ‘lib’ folder. Files who are not in the ‘lib’ or ‘minified’ folder will be minified, parsed and compressed if using the Apace MVC environment CLI.

### 4. Built in Functions

**4.1 Controller functions**

``` $this->enableCache(true) ```
- Description: Caches a view. The cache is automatically minified for better performance, 
it also takes the current language in consideration - (cache is disabled by default)

``` $this->setView('folder/view') ```           
- Description: Select a view

``` $this->setLayout(layout ) ```                  
- Description: Set the main layout - Changes the main default layout template

``` $this->setViewData('var', $data) ```         
- Description: Set view data - The data 'variable' OR 'array' is automatically escaped from XSS attacks

``` $this->data['var'] = 'string' ```            
- Description: Set view data - The data set with this method is not escaped and therefore unsafe

``` $this->getPostData($data) ```               
- Description: Get sanitized post variable from a form

``` return $this->json($res) ```
- Description: Return Json format

### 4.2 Database functions

``` Apace::db()->query('SELECT * FROM table') ```
- Description: Instantiate database connection from anywhere in the app

``` $this->db->query('SELECT * FROM table') ```
- Description: Instantiate database connection from a model only

### 4.3 Config functions

``` Config::parseSystemConfig() ```      
- Description: Get parsed system configuration settings

``` Config::parseAppConfig() ```				
- Description: Get parsed app configuration settings

``` Config::getDeploymentStatus() ```		
- Description: Get current deployment status as a string

### 4.4 URL related functions
		
``` Apace::baseUrl() ```
- Description: Get the apps base url as a string

``` Apace::fullBaseUrl() ```
- Description: Get the apps base url including the current language

``` Apace::getDataUrl($folder) ```
- Description: Get base path to assets such as css, images and javascript followed by a slash

``` Apace::getRefererUrl()      ```              
- Description: Get the referer url as string

``` Apace::redirect($url) ```
- Description: Redirect to another page

### 4.5 Router functions

``` Apace::getRouter()->getParam(1) ```
- Description: Get specific param from router as string

``` Apace::getRouter()->getParams() ```
- Description: Get all params from router as array

``` Apace::getRouter()->getUri() ```
- Description: Get the entire Uri as string

``` Apace::getRouter()->getController() ```
- Description: Get the current controller as string

``` Apace::getRouter()->getAction() ```
- Description: Get the current action as string

``` Apace::getRouter()->getLanguage() ```
- Description: Get the current language as string

### 4.6 Misc Functions

``` Apace::loadModel('index') ```
- Description: Load a model (without 'Model' prefix)

``` Apace::loadController('index') ```
- Description: Load a Controller (without 'Controller' prefix)

### 4.7 Session

``` $session = new APSessionHandler() ```	 
- Description: Recommended way to load a session  A session can be shared between multiple applications. 

``` $session->start() ```
- Description: Start session

``` $session->put('key', 'value') ```
- Description: Save session value by key

``` $session->get('key') ```
- Description: Get session value from key

``` $session->destroy() ```
- Description: End a session

``` $session->isActive() ```
- Description: Returns true if session is active

### 4.8 Plugins
		
- deprecated

### 4.9 Language

``` __('lng.test', 'default value') ```
- Description: Echo a language string - The built in language switcher function is seo friendly

## 5. Examples


**Standard Controller class**

```
class IndexController extends Controller {

	public function index() {
		// Hi
	}

}
```

**Standard Model class**

```
class IndexModel extends Model {

	public function index() {
		// Hi
	}

}
```

**Mysql PDO - fetch data from database**

```
$bind = array (
      ':bindkey' => 'bindvalue',
);

$results = Apace::$db->query('SELECT * FROM user where username = :bindkey, $bind);

foreach ($results as $result) {
      echo $result[username];
}
```


**Router mapping**

```
'home'         =>  url to map
'controller'   =>  is the actual controller class to map the url to
'action'       =>  the action of the controller class

$router = array (
	‘home’ => array(
		'controller' => 'index',
		'action'     => 'samples',
	),
);
```