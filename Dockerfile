FROM debian:buster-slim

RUN \
echo 'Acquire::http::No-Cache true;' >> /etc/apt/apt.conf \
&& echo 'Acquire::http::Pipeline-Depth 0;' >> /etc/apt/apt.conf

RUN \
mkdir -p /data/site/public_html /data/site/log /data/config /run/php/

COPY scripts/docker-entrypoint.sh /
COPY src/supervisord.conf /etc/supervisord.conf
COPY src/html.zip /data/site/public_html/html.zip

##Standart bazi servisleri kuruyoruz
RUN \
apt-get update && apt-get upgrade \
&& apt install -y  wget curl git snmp vnstat msmtp git tzdata openssh-server cron htop p7zip-full nano supervisor \
&& apt-get install --no-install-recommends --no-install-suggests -q -y \
apt-utils nano zip unzip python-pip python-setuptools git libmagickwand-dev

##Php servisi ve bazi gereksinimleri kuruyoruz
RUN \
OS_VERSION=`cat /etc/os-release |grep VERSION_CODENAME | cut -d "=" -f 2` \
&& wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
&& echo "deb https://packages.sury.org/php/ $OS_VERSION main" > /etc/apt/sources.list.d/php.list \
&& apt update -y && apt install -y wget curl git snmp vnstat msmtp git tzdata openssh-server htop p7zip-full memcached redis-server nano supervisor \
&& apt-get install --no-install-recommends --no-install-suggests -q -y \
apt-utils nano zip unzip python-pip python-setuptools git libmemcached-dev libmemcached11 libmagickwand-dev \
php7.4 php7.4-phar php7.4-fpm php7.4-cli php7.4-bcmath php7.4-dev php7.4-common \
php7.4-json php7.4-opcache php7.4-readline php7.4-mbstring php7.4-curl php7.4-gd \
php7.4-mysql php7.4-zip php7.4-pgsql php7.4-dom php7.4-intl php7.4-iconv php7.4-exif \
php7.4-xml php-pear php7.4-pdo php7.4-apcu php7.4-bz2

##Mysql servisini kuruyoruz
RUN \
apt install -y mariadb-server mariadb-client

##Proje ve diger dosyalar indiriliyor
RUN \
wget https://files.phpmyadmin.net/phpMyAdmin/4.9.5/phpMyAdmin-4.9.5-all-languages.zip && mv phpMyAdmin-4.9.5-all-languages.zip /data/site/public_html/phpmyadmin.zip \
&& cd /data/site/public_html/ && unzip /data/site/public_html/phpmyadmin.zip && unzip /data/site/public_html/html.zip \
&& mv /data/site/public_html/html/* /data/site/public_html/ \
&& mv /data/site/public_html/phpMyAdmin-4.9.5-all-languages /data/site/public_html/phpmyadmin

##Mysql Servisini hazir hale getiriyoruz
RUN \
mysql_install_db > /dev/null \
&& mkdir -p /run/mysqld \
&& chown -R mysql:mysql /run/mysqld \
&& chown -R mysql:mysql /var/lib/mysql/ \
&& chmod 777 /run/mysqld \
&& rm -f /run/mysqld/msqld.sock \
&& mysqld --user=root --console & \
sleep 10 \
&& mysql -u root -e "SET GLOBAL sql_mode = '';" \
&& mysql -u root -e "CREATE DATABASE ders" \
&& mysql --default-character-set=utf8 ders < /data/site/public_html/ders.sql \
&& mysql -u root -e "GRANT ALL PRIVILEGES ON ders.* TO 'users'@'localhost' IDENTIFIED BY '2154264**' WITH GRANT OPTION;"


##Apache servisini kuruyorz
RUN \
rm -rf /var/lib/apt/lists && \
rm -rf /etc/apt/sources.list.d && \
apt-get update -y && \
apt-get install -y apache2 && \
a2enmod proxy && \
a2enmod proxy_http && \
a2enmod authn_core && \
a2enmod alias && \
a2enmod headers && \
a2enmod authz_core && \
a2enmod authz_host && \
a2enmod authz_user && \
a2enmod dir && \
a2enmod env && \
a2enmod proxy_fcgi setenvif && \
a2enconf php7.4-fpm && \
a2enmod mime && \
a2enmod reqtimeout && \
a2enmod rewrite && \
a2enmod deflate && \
a2enmod ssl && \
apt-get autoremove -y && \
apt-get clean \
&& rm -rf /var/lib/apt/listsRUN echo Europe/Brussels > /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata

RUN ln -sf /dev/stdout /var/log/apache2/access.log \
&& ln -sf /dev/stderr /var/log/apache2/error.log \
&& rm /etc/apache2/sites-enabled/000-default.conf \
&& rm /etc/apache2/sites-available/000-default.conf \
&& rm -rf /var/www/html \
&& ln -s /data/site/public_html /var/www/html

##Atiklar siliniyor
RUN \
rm -Rf /data/site/public_html/html.zip /data/site/public_html/phpmyadmin.zip data/site/public_html/ders.sql /data/site/public_html/html

RUN chmod 0777 /docker-entrypoint.sh
EXPOSE 443 80 3306 21 3306 28017 4369 5671 5672 25672 15671 15672 9306

VOLUME /data

CMD ["/docker-entrypoint.sh"]
