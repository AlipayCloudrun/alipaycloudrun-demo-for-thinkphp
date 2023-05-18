# 采用centos官方镜像做为运行时镜像
FROM centos:7.2.1511

# 设定工作目录
WORKDIR /app

# 设置时区
RUN ln -snf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime && \
    echo Asia/Shanghai > /etc/timezone

# 安装基础命令和依赖库
RUN yum update -y && yum install -y epel-release \
    && rpm -Uvh http://rpms.remirepo.net/enterprise/remi-release-7.rpm \
    && yum install -y php74 php74-php-fpm php74-php-mysqlnd php74-php-opcache php74-php-xml \
    php74-php-gd php74-php-devel php74-php-mbstring php74-php-json php74-php-bcmath \
    php74-php-pdo php74-php-gd php74-php-pecl-zip \
    nginx vim wget net-tools iproute libzip telnet lsof less java-1.8.0-openjdk \
    && rm -rf /var/cache/yum/*

# 将项目目录下所有文件拷贝到工作目录
COPY . /app

# 替换nginx、fpm、php配置
RUN cp -f /app/conf/nginx.conf /etc/nginx/nginx.conf \
    && cp -f /app/conf/fpm.conf /etc/opt/remi/php74/php-fpm.d/www.conf \
    && cp -f /app/conf/php.ini /etc/opt/remi/php74/php.ini \
    && chmod 777 /var/opt/remi/php74/lib/php/session \
    && mkdir -p /run/nginx \
    && chmod -R 777 /app \
    && echo "alias ll='ls -l'" >> ~/.bash_profile \
    && ln -sf /usr/bin/php74 /usr/bin/php \
    && ln -sf /opt/remi/php74/root/usr/sbin/php-fpm /usr/sbin/php-fpm

# 暴露端口
# 此处端口必须与构建小程序服务端时填写的服务端口和探活端口一致，不然会部署失败
EXPOSE 80

# 执行启动命令
CMD ["sh", "run.sh"]