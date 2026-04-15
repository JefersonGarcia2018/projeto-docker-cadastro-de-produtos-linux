FROM node:22-alpine as build-stage
RUN npm install -g @quasar/cli
WORKDIR /app
COPY package*.json ./
RUN npm install --ignore-scripts
COPY . .
RUN quasar build

FROM nginx:stable-alpine as production-stage
COPY --from=build-stage /app/dist/spa /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]