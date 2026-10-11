FROM node:24-alpine AS build

WORKDIR /app

RUN apk add --no-cache git\
    && git clone --single-branch --branch v0.10.1 https://github.com/wsdl-web/wsdl-web.git /app\
    && sed -i "s|base: '/',|base: '/soap/doc',|g" vite.config.ts\
    && npm ci \
    && npm run build \
    && apk del git

FROM nginxinc/nginx-unprivileged:1.27.2-alpine3.20

ENV NGINX_ENVSUBST_FILTER="^WSDL_"
ENV WSDL_DEFAULT=

COPY --from=build /app/dist /usr/share/nginx/html

COPY default.conf.template /etc/nginx/templates/default.conf.template

EXPOSE 8080
