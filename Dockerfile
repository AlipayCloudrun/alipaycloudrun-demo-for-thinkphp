# 采用alpine官方镜像做为运行时镜像
FROM alpine:3.13

# 设定工作目录
WORKDIR /app

# 设置时区
RUN ln -snf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime && \
    echo Asia/Shanghai > /etc/timezone

# 安装基础命令（选用国内阿里云镜像源以提高下载速度）
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories \
    && apk add --update --no-cache ca-certificates curl tzdata php-posix php7 php7-json \
    php7-ctype php7-exif php7-pdo php7-pdo_mysql php7-fpm php7-curl nginx \
    && rm -f /var/cache/apk/*


# 将项目目录下所有文件拷贝到工作目录
COPY . /app

# 替换nginx、fpm、php配置
RUN cp /app/conf/nginx.conf /etc/nginx/conf.d/default.conf \
    && cp /app/conf/fpm.conf /etc/php7/php-fpm.d/www.conf \
    && cp /app/conf/php.ini /etc/php7/php.ini \
    && mkdir -p /run/nginx \
    && chmod -R 777 /app/runtime \
    && mv /usr/sbin/php-fpm7 /usr/sbin/php-fpm

# 暴露端口
# 此处端口必须与构建小程序服务端时填写的服务端口和探活端口一致，不然会部署失败
EXPOSE 80

# 执行启动命令
CMD ["sh", "run.sh"]