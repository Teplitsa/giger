# Гигер #

**Адаптивный сайт-конструктор для НКО** - [giger.te-st.ru](https://giger.te-st.ru)

![Гигер](https://giger.te-st.ru/assets/img/giger-logo-temp.png?stamp=186)

## Основные функции:

- адаптивный дизайн на базе Google Material Design
- предустановленный набор плагинов на базе WordPress
- автоматизация обновлений с помощью Composer
- SASS для создания стилей, минификация и автоматизация фронтенда с помощью Gulp
- инлайновые SVG для иконок и других изображений
- поддержка адаптивных изображений
- встроенные кнопки шаринга - Viber, Telegram, WhatsApp - с диплинками для мобильных
- продуманная стартовая структура данных - новости, проекты, профили людей и организаций
- календарь событий
- формы подписки и контактные формы (с вомзожностью экспорта данных)
- пожертвования с помощью плагина Онлайн-Лейка
- несколько цветовых схем оформления

## Состав пакета

- тема оформления Гигер

- набор демо-данных в виде дампа базы

- набор демо-изображений 

- ядро WordPress последней версии

- набор плагинов для реализации основных функций сайта

	- [Cyr to Lat enhanced](https://wordpress.org/plugins/cyr3lat/) 
	- [Crop-Thumbnails](https://wordpress.org/plugins/crop-thumbnails/) 
	- [Disable Comments](https://wordpress.org/plugins/disable-comments/)         
	- [Imsanity](https://wordpress.org/plugins/imsanity/) 
	- [Leyka](https://wordpress.org/plugins/leyka/) 
	- [Media Search Enhanced](https://wordpress.org/plugins/media-search-enhanced/) 
	- [Responsive Lightbox by dFactory](https://wordpress.org/plugins/responsive-lightbox/)         
	- [Simple CSS for widgets](https://wordpress.org/plugins/simple-css-for-widgets/) 
	- [Simple Google Maps Short Code](https://wordpress.org/plugins/simple-google-maps-short-code/) 
	- [Widget Logic](https://wordpress.org/plugins/widget-logic/) 
	- [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) 
	- [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/)
	- [Posts 2 Posts](https://wordpress.org/plugins/posts-to-posts/) 
	- [Ninja Forms](https://wordpress.org/plugins/ninja-forms/) 
	- [CMB2](https://wordpress.org/plugins/cmb2/)
	
- набор служебных плагинов "для разработчиков"

	- [Debug Bar](https://wordpress.org/plugins/debug-bar/) 
	- [Query Monitor](https://wordpress.org/plugins/query-monitor/)       
	- [Debug Objects](https://wordpress.org/plugins/debug-objects/) 	
	- [Force Regenerate Thumbnails](https://wordpress.org/plugins/force-regenerate-thumbnails/) 
	- [Post Duplicator](https://wordpress.org/plugins/post-duplicator/) 



## Установка [подробности по установке в см. вики](https://github.com/Teplitsa/giger/wiki/%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0)



**Установка на Vagrant**

**Общие требования**
- в BIOS должа быть включена [аппаратная поддержка виртуализации](https://ru.wikipedia.org/wiki/%D0%90%D0%BF%D0%BF%D0%B0%D1%80%D0%B0%D1%82%D0%BD%D0%B0%D1%8F_%D0%B2%D0%B8%D1%80%D1%82%D1%83%D0%B0%D0%BB%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D1%8F) (Intel VT или AMD-V)
- минимальное место на диске 3.5 GB

***Установка на Ubuntu 15.10***

1. установите необходимые зависимости: 
	- `sudo apt-get install vagrant git virtualbox` 

2. добавьте `192.168.13.37  giger.local` в файл хостов: 
	- `sudo -- sh -c "echo  \ \ >> /etc/hosts";sudo -- sh -c "echo 192.168.13.37  giger.local >> /etc/hosts"` 

3. создайте в вашей домашней директории папку проекта и перейдите в нее: 
	- `mkdir ~/giger.local &&  cd ~/giger.local` 

4. клонируйте репозиторий проекта Гигер: 
	- `git clone https://github.com/Teplitsa/giger.git .` 

5. запустите Vagrant командой

`vagrant up`

***Установка на OS X***

1. Установитe [Vagrant](http://www.vagrantup.com/downloads), [VirtualBox](https://www.virtualbox.org/) и [Git](https://git-scm.com/downloads) 

2. добавьте `192.168.13.37  giger.local` в файл хостов:
	- `sudo -- sh -c "echo  \ \ >> /etc/hosts";sudo -- sh -c "echo 192.168.13.37  giger.local >> /etc/hosts"`

3. создайте в вашей домашней директории папку проекта и перейдите в нее:
	- `mkdir ~/giger.local &&  cd ~/giger.local`

4. клонируйте репозиторий проекта Гигер: 
	- `git clone https://github.com/Teplitsa/giger.git .`

5. запустите Vagrant командой
	- `vagrant up`

***Установка на Windows***

1. Установитe:
- Vagrant http://www.vagrantup.com/downloads
- git для Windows http://git-scm.com/download/win
- виртуализатор VirtualBox https://www.virtualbox.org/wiki/Downloads

2. добавьте `192.168.13.37  giger.local` в файл локальных хостов %SystemRoot%\system32\drivers\etc\hosts

3. создайте в вашей домашней директории папку проекта и перейдите в нее:
	- `mkdir ~/giger.local`
	- `cd ~/giger.local`

4. клонируйте репозиторий проекта Гигер: 
	- `git clone https://github.com/Teplitsa/giger.git .`

5. запустите Vagrant командой
	- `vagrant up`
	- Eсли запуск не сработал, возможно дело в наличии кириллицы в имени системного пользователя, т.к. домашняя папка _vagrant_ по умолчанию располагается в ней. Исправить это можно создав папку для _vagrant_ (например: `E:\vagrant`) и установив ее как домашнюю папку _vagrant_, выполнить команду `set VAGRANT_HOME=E:\vagrant`.

***Проверка установкки***

Проверьте, что сайт отвечает по адресу `http://giger.local`. Вход в админку `http://giger.local/core/wp-login.php` с логином _giger_ и паролем _121121_. После входа необходимо создать нового пользователя http://giger.local/core/wp-admin/user-new.php, а аккаунт _giger_ удалить.

Доступ к гостевой машине - `vagrant ssh`, выход - `exit`, остановить машину без потери данных - `vagrant suspend`, возобновить работу - `vagrant resume`, удалить гостевую машину `vagrant destroy`. Подробнее о командах Vagrant читайте в[документации](https://docs.vagrantup.com/v2/cli/index.html). Файлы проекта на гостевой машине расположены в папке `/var/www/public/`.

**Уставка без Vagrant**

Нужно:
- LAMP: PHP 5.6+ и MySQL 5.6+ (поддержка кодировки utf8mb4)
- Composer для PHP ([подробнее об установке](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)), с правами на запуск в папке проекта
- Для локальной установки: добавить `127.0.0.1  giger.local` в файл хостов
- На удаленном сервере: домен, указывающий на папку проекта


0. Создать папку проекта:
	- `mkdir giger.local`
	- `cd giger.local`

1. Клонировать репозиторий: `git clone https://github.com/Teplitsa/giger.git .`

2. Создать базу и импортировать в нее тестовые данные:
	- `echo 'CREATE DATABASE IF NOT EXISTS giger' | mysql --user=your_db_username --password=your_db_password`
	- `unzip -p ./attachments/startertest.sql.zip | mysql --user=your_db_username --password=your_db_password giger`

3. Запустить: `composer install`

4. Создать конфигурационный файл из шаблона и заполнить в нем информацию о доступе к базе данных (при установке на домен, отличный от giger.local, необходимо сменить также и домен):
	- `cat wp-config-orig.php | sed 's/dev_db/giger/g;s/dev_user/your_db_username/g;s/dev_password/your_db_password/g' > wp-config.php` 

5. Распаковать содержимое папки с изображениями `attachments/uploads.zip` в `wp-content/uploads`:
	- `unzip ./attachments/uploads.zip -d ./wp-content/`

6. Создать файл `.htaccess` из шаблона и настроить права доступа к нему:
	- `cat ./attachments/.htaccess.orig > .htaccess`
	- `chmod -v 666 .htaccess`

7. Сайт отвечает по адресу http://giger.local (или вашему домену). Вход в админку http://giger.local/core/wp-login.php с логином _giger_ и паролем _121121_. Необходимо создать нового пользователя http://giger.local/core/wp-admin/user-new.php, а аккаунт _giger_ удалить.

**Уставка без Vagrant на хостинг**

Нужно:
- LAMP: PHP 5.6+ и MySQL 5.6+ (поддержка кодировки utf8mb4)
- Composer для PHP ([подробнее об установке](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)), с правами на запуск в папке проекта
- Для локальной установки: добавить `127.0.0.1  giger.local` в файл хостов
- На удаленном сервере: домен, указывающий на папку проекта


0. Зайти в папку, в которой должен размещаться код сайта (DocumentRoot).

1. Клонировать репозиторий: `git clone https://github.com/Teplitsa/giger.git .` (не забудьте точку в конце, она заставляет клонировать код в ту папку, в которой вы находитесь).

1.1. Перенести все файлы из папки giger.egg  на уровень выше (т.е. в DocumentRoot): 
	- `mv giger.egg/* ./`

2. Создать базу и импортировать в нее тестовые данные:
	- `echo 'CREATE DATABASE IF NOT EXISTS giger' | mysql --user=your_db_username --password=your_db_password`
	- `unzip -p ./attachments/startertest.sql.zip | mysql --user=your_db_username --password=your_db_password giger`

3. Запустить: `composer install`
 
3.1. Если не срабатывает, то попробуйте следовать советам по ссылке: https://github.com/Teplitsa/giger/wiki/%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0
п.2.

4. Создать конфигурационный файл из шаблона и заполнить в нем информацию о доступе к базе данных (при установке на домен, отличный от giger.local, необходимо сменить также и домен):
	- `cat wp-config-orig.php | sed 's/dev_db/giger/g;s/dev_user/your_db_username/g;s/dev_password/your_db_password/g;s/giger\.local/вашсайт\.ru/g' > wp-config.php` 

5. Распаковать содержимое папки с изображениями `attachments/uploads.zip` в `wp-content/uploads`:
	- `unzip ./attachments/uploads.zip -d ./wp-content/`

6. Создать файл `.htaccess` из шаблона и настроить права доступа к нему:
	- `cat ./attachments/.htaccess.orig > .htaccess`
	- `chmod -v 666 .htaccess`

7. В базе WP заменить домен giger.local на вашсайт.ru. Для этого нужно скачать утилиту dbreplace(https://interconnectit.com/products/search-and-replace-for-wordpress-databases/) в папку сайта. Зайти в нее и запустить 2 команды:
	- `php srdb.cli.php -h localhost -n YOUR_DB -u YOUR_DB_USER -p YOUR_DB_PASSWORD -s http://giger.local -r http://вашсайт.ru`
	- `php srdb.cli.php -h localhost -n YOUR_DB -u YOUR_DB_USER -p YOUR_DB_PASSWORD -s giger.local -r вашсайт.ru`
	- удалить dbreplace из папки сайта

8. Сайт отвечает по адресу http://вашсайт.ru. Вход в админку http://вашсайт.ru/core/wp-login.php с логином _giger_ и паролем _121121_. Необходимо создать нового пользователя http://вашсайт.ru/core/wp-admin/user-new.php, а аккаунт _giger_ удалить.

## Изменение исходного кода темы

Сайт работает и можно вносить свои материалы. Если вы хотите корректировать код темы, потребуются дополнительные настройки рабочего окружения для использования таск-менеджера [Gulp](http://gulpjs.com/) (при установке на Vagrant указанные компоненты уже присутствуют в системе):

- Node.js и npm ([подробнее об установке](https://nodejs.org/en/download/))
- Bower ([подробнее об установке](http://bower.io/#install-bower))
- Gulp, установленный глобально ([подробнее об установке](https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md))

Порядок установки зависимостей:

```
cd wp-content/themes/giger/
npm install
bower install
```

Исходники стилей темы написаны с использованием [SASS](http://sass-lang.com/) и расположены в папке `wp-content/themes/giger/src/sass/`. Запустите `gulp watch` и редактируйте исходный SASS код - соответствующие .css файлы сгенерируются автоматически. Используйте `gulp full-build --prod` для генерации production-ready минифицированных стилей. 

**Как сменить логотип**

Логотип должен быть в формате .svg в двух вариантах: полный для главной страницы - назовите файл pic-logo.svg и сохраните в папке `wp-content/themes/giger/src/svg/`, и значок для шапки и меню сайта - назовите файл plain-logo-small.svg и сохраните в той же папке.

Запустите `gulp svg-opt` для замены логотипов в файлах шаблонов. При необходимости скорректируйте размер и позиции логотипов в файле `wp-content/themes/giger/src/sass/_logos.scss`.

## Дополнительная информация

**Подключение по SSH через Putty**

Когда giger.local запущен, vagrant создает приватный ключ доступа в формате OpenSSH. Он находится в папке giger.local/.vagrant/machines/default/virtualbox/private_key. Чтобы загрузить этот ключ в Pagent (Putty authentication agent), нужно сначала конвертировать его в формат ppk. Это можно сделать через puttygen. Загружаем его туда и сохраняем приватный ключ. Он будет уже в формате ppk.


## Помощь проекту

Гигер создан и поддерживается [Теплицей социальных технологий](https://te-st.ru).

Вы можете помочь следующими способами:

  * Добавить сообщение об ошибке или предложение по улучшению на GitHub.
  * Поделиться улучшениями кода, послав нам Pull Request.
  * Сделать перевод системы или оптимизировать его для вашей страны (перевод на англ. уже существует).
  
Если вам нужна помощь волонтеров в установке и настройке - создайте задачу на [https://itv.te-st.ru](https://itv.te-st.ru).
