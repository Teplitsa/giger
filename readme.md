# Giger #

**Cтартовый пакет для сайта НКО** - [giger.te-st.ru]()

![Гигер](http://leyka.te-st.ru/wp-content/uploads/assets/giger-logo-temp.png?stamp=123)

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
	- [WP Sync DB](https://github.com/wp-sync-db/wp-sync-db) 
	- [WP Sync DB Media Files](https://github.com/wp-sync-db/wp-sync-db-media-files)
	- [Force Regenerate Thumbnails](https://wordpress.org/plugins/force-regenerate-thumbnails/) 
	- [Post Duplicator](https://wordpress.org/plugins/post-duplicator/) 
	
- тема оформления Giger

- набор демо-данных в виде дампа базы

- набор демо-изображений 


## Установки

*Установка на Vagrant*

1. Установить vagrant ([подробнее об установке](https://docs.vagrantup.com/v2/installation/index.html)).

2. Добавить строку '192.168.33.10  giger.local' в файл хостов:
	- для OS X: `sudo -- sh -c "echo  \ \ >> /etc/hosts";sudo -- sh -c "echo 192.168.33.10  giger.local >> /etc/hosts"`
	- для других систем - не знаю
	
3. Клонировать репозиторий в папку проекта (должна быть пустой):
	- `git clone https://github.com/Teplitsa/giger.git .`

4. Запустить проект vagrant:
	- `vagrant up`

5. Cайт доступен по адресу http://giger.local.  Вход в административную часть http://giger.local/core/wp-login.php с логином `giger` и паролем `121121`. Необходимо создать нового пользователя, используя стандартный диалог WordPress http://giger.local/core/wp-admin/user-new.php, а аккаунт `giger` удалить.


*Уставка без Vagrant*

Нужно:
- LAMP: PHP 5.6+ и MySQL 5.6+ (поддержка кодировки utf8mb4)
- Composer для PHP ([подробнее об установке](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)), с правами на запуск в папке проекта
- Для локальной установки: добавить строку '127.0.0.1  giger.local' в файл хостов
- На удаленном сервере: домен, указывающий на папку проекта

Все действия осуществляются в папке проекта.

1. Клонировать репозиторий в папку проекта (она должна быть пустой):
	- `git clone https://github.com/Teplitsa/giger.git .`

2. Создать базу и импортировать в нее тестовые данные:
	- `echo 'CREATE DATABASE IF NOT EXISTS giger' | mysql --user=your_db_username --password=your_db_password`
	- `unzip -p ./attachments/startertest.sql.zip | mysql --user=your_db_username --password=your_db_password giger`

3. Установить WordPress и необходимые плагины с помощью Composer:
	- `composer install`

4. Создать конфигурационный файл из шаблона и заполнить в нем информацию о доступе к базе данных (при установке на домен, отличный от giger.local, необходимо сменить также и домен):
	- `cat wp-config-orig.php | sed 's/dev_db/giger/g;s/dev_user/your_db_username/g;s/dev_password/your_db_password/g' > wp-config.php` 

5. Распаковать содержимое папки с изображениями `attachments/uploads.zip` в `wp-content/uploads`:
	- `unzip ./attachments/uploads.zip -d ./wp-content/`

6. Создать файл `.htaccess` из шаблона и настроить права доступа к нему:
	- `cat ./attachments/.htaccess.orig > .htaccess`
	- `chmod -v 666 .htaccess`

7. Сайт отвечает по адресу _http://giger.local_ (или вашему домену). Вход в административную часть _http://giger.local/core/wp-login.php_ с логином _giger_ и паролем _121121_. Необходимо создать нового пользователя, используя стандартный диалог WordPress _http://giger.local/core/wp-admin/user-new.php_, а аккаунт _giger_ удалить.


*Изменение исходного кода темы*

Сайт работает и можно вносить свои материалы. Если вы хотите корректировать код темы, потребуются дополнительные настройки рабочего окружения для использования таск-менеджера [gulp](http://gulpjs.com/).

//про гульп допишем тут


## Помощь проекту

Giger создан и поддерживается [Теплицей социальных технологий](https://te-st.ru).

Вы можете помочь следующими способами:

  * Добавить сообщение об ошибке или предложение по улучшению на GitHub.
  * Поделиться улучшениями кода, послав нам Pull Request.
  * Сделать перевод системы или оптимизировать его для вашей страны (перевод на англ. уже существует).
  
Если вам нужна помощь волонтеров в установке и настройке - создайте задачу на [https://itv.te-st.ru](https://itv.te-st.ru).