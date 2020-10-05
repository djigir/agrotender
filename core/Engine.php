<?php
namespace Core;
/**
 * Handles the handlers :)
 * Send HTTS Response, included routing rules and starts
 * the controller method caused by the routing condition.
 */
class Engine {

  public    $handlers = ['request', 'session', 'cookie', 'view', 'response', 'db'];
  protected $data;
  private   $routingRules = [
    ["main/main", "/", "Main:index", "GET|POST"],
    ["main/companies", "/kompanii", "Main:companies", "GET|POST"],
    ["main/companies-r", "/kompanii/region_(region:str)/(?:index|t(rubric:num)(?:|_p(pageNumber1:num))|)(?:p(pageNumber2:num)|)", "Main:companies", "GET|POST"],
    ["main/companies-s", "/kompanii/s/(query:any)(?:/region_(region:str)|)(?:/t(rubric:num)|/index|)(?:/p(pageNumber1:num)|)(?:|)", "Main:companies", "GET|POST"],
    ["board/index", "(?:/s/(query:any)|)/board(?:/region_(region:str)|)(?:|\/(type:str))(?:|_t(rubric:num))(?:|_p(pageNumber:num))", "Board:index", "GET|POST"],
    ["board/advert", "/board/post-(id:num)", "Board:advert", "GET|POST"],
    ["board/author", "/board/author/(id:num)", "Board:author", "GET|POST"],
    ["board/add", "/board/addpost", "Board:add", "GET|POST"],
    ["board/edit", "/board/edit(id:num)", "Board:edit", "GET|POST"],
    ["board/success", "/board/success", "Board:success", "GET|POST"],
    ["main/traders-new", "/newtraders(?:/region_(region:str)|)(?:/tport_(port:str)|)(?:/(rubric:any)|/index|)", "Main:traders_new", "GET|POST"],
    ["main/traders", "/traders(?:/region_(region:str)|/tport_(port:str)|/ports_(region_port:str))(?:/(rubric:any)|/index|)", "Main:traders", "GET|POST"],
	["main/traders_dev", "/traders_dev(?:/region_(region:str)|/tport_(port:str)|/ports_(region_port:any))(?:/(rubric:any)|/index|)", "Main:traders_dev", "GET|POST"],    
	
    ["main/traders-s", "/traders_sell(?:/region_(region:str)|/tport_(port:str)|)(?:/(rubric:any)|/index|)", "Main:traders:sell", "GET|POST"],
    ["main/traders-f", "/traders_forwards(?:/region_(region:str)|/tport_(port:str))(?:/(rubric:any)|/index|)", "Main:tradersForwards", "GET|POST"],
   // ["main/traders_analitic", "/traders_analitic(?:/region_(region:str)|/tport_(port:str))(?:/(rubric:any)|/index|)", "Main:analitic", "GET|POST"],
    //["main/traders_analitic-s", "/traders_analitic_sell(?:/region_(region:str)|/tport_(port:str)|)(?:/(rubric:any)|/index|)", "Main:analitic:sell", "GET|POST"],
    ["main/elev", "/elev(?:/(region:str)|)", "Main:elev", "GET|POST"],
    ["main/elev-item", "/elev/(id:num)-(url:any)", "Main:elevItem", "GET|POST"],
    ["main/signin", "/buyerlog", "Main:signin", "GET|POST"],
    ["main/signup", "/buyerreg", "Main:signup", "GET|POST"],
    ["main/restore", "/buyerpassrest", "Main:restore", "GET|POST"],
    ["main/act", "/act/(hash:any)", "Main:act", "GET"],
    ["main/thankyou", "/thankyou", "Main:thankyou", "GET"],
    ["main/error", "/error", "Main:info:error", "GET"],
    ["main/success", "/success", "Main:info:success", "GET"],
    ["main/logout", "/logout", "Main:logout", "GET"],
    ["main/404", "/notfound", "Main:pageNotFound", "GET"],
    ["user/main", "/u/", "User:index", "GET|POST"],
    ["user/contacts", "/u/contacts", "User:contacts", "GET|POST"],
    ["user/notify", "/u/notify", "User:notify", "GET|POST"],
    ["user/reviews", "/u/reviews", "User:reviews", "GET|POST"],
    ["user/proposeds", "/u/proposeds", "User:proposeds", "GET|POST"],
    ["user/company", "/u/company", "User:company", "GET|POST"],
    ["user/news", "/u/news", "User:news", "GET|POST"],
    ["user/vacancy", "/u/vacancy", "User:vacancy", "GET|POST"],
    ["user/posts", "/u/posts", "User:ads", "GET|POST"],
    ["user/prices", "/u/prices", "User:prices", "GET|POST"],
    ["user/pricesForward", "/u/prices/forwards", "User:pricesForward", "GET|POST"],
    ["user/pricesContacts", "/u/prices/contacts", "User:pricesContacts", "GET|POST"],
    ["user/limits", "/u/posts/limits", "User:limits", "GET|POST"],
    ["user/upgrade", "/u/posts/upgrade", "User:upgrade", "GET|POST"],
    ["user/payBalance", "/u/balance/pay", "User:payBalance", "GET|POST"],
    ["user/historyBalance", "/u/balance/history", "User:historyBalance", "GET|POST"],
    ["user/docsBalance", "/u/balance/docs", "User:docsBalance", "GET|POST"],
    ["main/changeEmail", "/changeEmail/(id:num)/(email:any)", "Main:changeEmail", "GET"],
    ["main/pay", "/pay", "Main:pay", "GET|POST"],
    ["company/main", "/kompanii/comp-(companyId:num)", "Company:index", "GET|POST"],
    //["company/about", "/kompanii/comp-(companyId:num)-about", "Company:about", "GET|POST"],
    ["company/adverts", "/kompanii/comp-(companyId:num)-adverts", "Company:adverts", "GET|POST"],
    ["company/contacts", "/kompanii/comp-(companyId:num)-cont", "Company:contacts", "GET|POST"],
    ["company/reviews", "/kompanii/comp-(companyId:num)-reviews", "Company:reviews", "GET|POST"],
    ["company/prices", "/kompanii/comp-(companyId:num)-prices", "Company:prices", "GET|POST"],
    ["company/forwards", "/kompanii/comp-(companyId:num)-forwards", "Company:forwards", "GET|POST"],
    ["company/traderContacts", "/kompanii/comp-(companyId:num)-traderContacts", "Company:traderContacts", "GET|POST"],
    ["company/news", "/kompanii/comp-(companyId:num)-news", "Company:news", "GET|POST"],
    ["company/newsItem", "/kompanii/comp-(companyId:num)-news-(id:num)", "Company:newsItem", "GET|POST"],
    ["company/vacancyItem", "/kompanii/comp-(companyId:num)-vacancy-(id:num)", "Company:vacancyItem", "GET|POST"],
    ["company/vacancy", "/kompanii/comp-(companyId:num)-vacancy", "Company:vacancy", "GET|POST"],
    ["main/addTrader", "/add_buy_trader", "Main:addTrader", "GET|POST"],
    ["main/news", "/news(?:/page_(pageNumber:num)_15|)", "Main:news", "GET"],
    ["main/newsItem", "/news/(month:num)_(year:num)/(url:any)", "Main:newsItem", "GET|POST"],
    ["main/faq", "/faq(?:/p_(pageNumber:num)/index|)", "Main:faq", "GET"],
    ["main/faqItem", "/faq/(url:any)", "Main:faqItem", "GET"],
    ["main/contacts", "/info/contacts", "Main:contacts", "GET"],
    ["main/orfeta", "/info/orfeta", "Main:orfeta", "GET"],
    ["main/limit_adv", "/info/limit_adv", "Main:limit_adv", "GET"],
    ["main/chat_bots", "/info/chat_bots", "Main:chat_bots", "GET"],
    ["main/reklama", "/reklama", "Main:reklama", "GET"],
    ["main/sitemap", "/sitemap(?:/(type:str)|)(?:/rubric-(rubric:num)(?:/region-(region:num)|)|)", "Main:sitemap", "GET"],
    ["main/api", "/api", "Main:api", "GET|POST"],
    ["main/api2", "/api2", "Main:api2", "GET|POST"],
    ["main/error404", "/404", "Main:error404", "GET"]
  ];

  public function handler($handlers, $receptive) {
  	foreach ($handlers as $key => $value) {
  	  if ($receptive == $this or explode("\\", get_class($receptive))[1] == 'models') {
        $className = ucfirst($value);
        $class     = new \ReflectionClass(__NAMESPACE__."\\".$className);
        $object    = $class->newInstance();
        $receptive->$value = $object;
      } else {
        if (is_object($value)) {
           $receptive->$key = $value;
        } else {
          $prop = new \ReflectionProperty(static::class, $key);
          if ($prop->isProtected()) {
            $receptive->$key = $value;
          }
        }
      }
  	}
  }

  public function run() {
    // Create routing object
    $route = new Route;
    // Add routing rules
    $route->add($this->routingRules);
    // Match the current route
    try{
	if (!$route->matchedRoute((new Request)->getMethod(), (new Request)->getPathInfo())) {
	    throw new \Exception('404');
	}
    }catch(\Exception $e) {
	(new Response)->redirect("/404");
    }
//    echo (new Request)->getPathInfo();
    // Routing parameters on url to View
    $this->data = $route->getParameters() + ['page' => $route->getpage()];
    // Add handlers
    $this->handler($this->handlers, $this);
    // Explode controller into a class and method
    $controller = explode(':', $route->getController());
    $className  = $controller[0];
    $method     = $controller[1];
    $params     = $controller[2] ?? null;
    // New Reflection Controller class
    $class      = new \ReflectionClass("App\controllers\\$className");
    // Instanse Controller class without constructor
    $object     = $class->newInstanceWithoutConstructor();
    // Handle handlers to Controller class
    $this->handler(get_object_vars($this), $object);
    // Invoke __construct of Controller class
    (new \ReflectionMethod($object, '__construct'))->invoke($object);
    // Check if method declared in the controller ($object)

    if (!method_exists($object, $method)) {
      throw new Fail("The method \"{$method}\" is not declared in the controller \"{$class}\".");
    }
    // Enabling Output Buffering
    ob_start();
    // Calling the method for the current route
    $params != null ? $object->$method($params) : $object->$method();
    // Get the contents of the output buffer
    $content = ob_get_contents();
    // Clear the output buffer and disable output buffering
    ob_end_clean();
    // Send response with headers and contnent
    $this->response->setBody($content)->send();
  }

}
