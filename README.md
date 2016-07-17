dyn_routing
===========

4 implementations of dynamic {bundle}/{controller}/{action} routing

##Dispatcher action

example urls: /app/default/index, /app/lucky/number, /app/unlucky/number, /option1/lucky/number, /option1/unlucky/number

* AppBundle
* Option1Bundle
* routing.yml:[1-6]

##Route loader

example urls: /option2/lucky/number, /option2/unlucky/number, /option2case2/lucky/number, /option2case2/unlucky/number

 * Option2Bundle
 * Option2case2Bundle
 * routing.yml:[8-10]
 * services.yml:[1-6]
 
##Prefix with annotations

example urls: /option3/lucky/number, /option3/unlucky/number

 * Option3Bundle
 * routing.yml:[12-15]
 
##RouterListener

example urls: /option4/lucky/number, /option4/unlucky/number

 * Option4Bundle
 * services.yml:[7-10]
 
