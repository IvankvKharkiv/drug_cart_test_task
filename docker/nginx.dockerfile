FROM nginx
ARG HOSTNAME

ADD  docker/conf/vhost.conf /etc/nginx/conf.d/default.conf

RUN sed -i "s/HOSTNAME_CONF/$HOSTNAME/g" /etc/nginx/conf.d/default.conf

WORKDIR /var/www/$HOSTNAME