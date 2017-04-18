# ppf 框架目录结构：

 ![image](https://github.com/taweisuode/ppf/blob/master/Public/Image/ppf_menu.png)

#### ppf框架是一个基于mvc模式的框架<br>
#### 有着最简单的路由分发以及mvc组件构成的框架。<br>
#### 模仿来自于thinkphp 以及zendframe。以及加入了类似smarty的模版引擎。全方面实现了一个框架从路由分发。载入配置文件。mvc模式以及最后的模版引擎实现。<br>
### 简单实现原理如下：
PHP每次接收到请求时都要初始化全部资源<br>
处理完毕后再释放全部的资源<br>
ppf框架接收到用户的请求后，需要一个初始化的过程<br>
在初始化时实例化框架的核心模块，然后在把请求传送给框架的相应模块进行处理<br>
所以在初始化完成后，我们还需要根据用户的请求来调用相应的控制器，所以我们需要一个分发器（dispatch）来对用户的请求进行分发。在控制器里，我们就可以调用数据模型和视图来处理用户的请求了。<br>

要处理用户的请求需要先初始化框架的核心模块<br>
如分发器模块，所以用户的请求首先需要被重定向至一个初始化页面，重定向可以使用.htaccess文件来实现<br>
在我们这个框架里，我们首先把所有的请求都重定向至index.php里，在index.php里面完成初始化操作：初始化核心模块，我们还可以在初始化时读入框架的配置文件信息<br>
然后调用分发器把请求分发到相应的控制器，实例化这个控制器，并调用控制器中的方法来处理用户的请求。<br>
在控制器里，我们可以获取用户的输入，判断用户的请求，然后调用相应的数据模型进行数据处理，控制器得到数据后，把数据传给视图，视图根据得到的数据返回一个页面给用户，请求结束。<br>

###### http请求－>.htaccess->index.php->载入config.php（实例化核心模块）->dispath:init()->调用相应的控制器－》view
在视图类中加了自定义的模版引擎。可以自己配置属于自己的模版语言以及方法<br>
具体模版类在/Library/Template.php 以及/Library/Compile.php<br>



Version 1可支持的模版引擎实现功能有<br>
```{$add} => <?php echo $add;?>```<br>   
```{if $add >0}aaa{else}bbb{/if} => <?php if($add > 0){aaa}else{bbbb} ?>```<br>  
```{foreach name=$aaa}{$key}{$val}{/foreach} => <?php foreach($aaa as $key=>$val){$key $val} ?>```<br>  
```{php echo 111;}{/php} => <?php echo 111;?>```<br>  
后续会进行补充添加


please join us in QQ:556830740
