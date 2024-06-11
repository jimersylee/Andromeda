# Summary 

Andromeda is a php framework,apply Di,Ioc

# Quick start

```shell
cd Andromeda
composer install
# start server
php -S localhost:8000
# curl or using browser
http://localhost:8000/index.php?p=home&c=index&a=index
http://localhost:8000/index.php?p=home&c=index&a=paramTest&p1=1&p3=2
```


# Todo

## Cache driver
- Redis
- Memcached
- File 

## Database driver
- MySQL

## Log driver
- File
- Elastic search


# Dev log
- 2024-06-11:升级依赖包;更新README
- 2017-10-16:实现获取post与get参数结合
- 2017-10-11:准备实现获取post参数
- 2017-10-11:实现获取action参数,以及必填非必填参数判断
- 2017-08-03:下一步实现获取action的参数,利用反射实现



 
