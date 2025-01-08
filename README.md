# 🧩 Proyecto de Integración y Despliegue Continuo con Kubernetes, Jenkins, Buildah y WordPress

Este repositorio contiene los archivos necesarios para desplegar y gestionar una aplicación **WordPress** mediante **Kubernetes (K3s)** y un flujo de **Integración y Despliegue Continuo (CI/CD)** utilizando **Jenkins** y **Buildah** para la creación de imágenes de contenedores.

El proyecto incluye la configuración de dos entornos: uno de **desarrollo local** y otro en **producción** alojado en un VPS. Ambos entornos utilizan configuraciones replicadas para garantizar la coherencia en el despliegue y la sincronización de datos.

---

## 📋 Descripción del Proyecto

Este proyecto busca automatizar el proceso de creación de imágenes de contenedores y el despliegue de un **CMS** en un entorno de **Kubernetes**, asegurando que los cambios realizados en el repositorio se reflejen automáticamente en los entornos de desarrollo y producción.

El flujo de trabajo implementa:
- **Creación de imágenes de contenedores con Buildah** directamente en los pipelines de Jenkins.
- **Sincronización de la base de datos** entre los entornos de desarrollo y producción.
- Despliegue automatizado de **WordPress** y **MySQL** utilizando recursos de Kubernetes.
- **Exposición de servicios** mediante un recurso **Ingress** y, en caso necesario, el uso de **ngrok** para pruebas temporales.

---

## ⚙️ Tecnologías Utilizadas

- **K3s**: Distribución ligera de Kubernetes utilizada para el despliegue.
- **Jenkins**: Herramienta de automatización para implementar un flujo de CI/CD.
- **Buildah**: Herramienta para la creación de imágenes de contenedores sin necesidad de un daemon como Docker.
- **WordPress**: Plataforma CMS utilizada para la aplicación web.
- **MySQL**: Base de datos utilizada para almacenar los datos de WordPress.
- **ngrok**: Herramienta utilizada para exponer servicios locales a través de Internet.

---

## 🚀 Flujo de Trabajo de IC/DC

1. **Commit en GitHub**: Los cambios realizados en el repositorio activan un webhook que inicia un pipeline en Jenkins.
2. **Creación de Imágenes con Buildah**: Jenkins utiliza **Buildah** para crear y actualizar las imágenes de contenedores de **WordPress** y **MySQL**.
3. **Despliegue en Desarrollo**: Jenkins despliega la aplicación en el entorno de desarrollo local utilizando las imágenes generadas.
4. **Sincronización de la Base de Datos**: Se exporta la base de datos del entorno de desarrollo al entorno de producción.
5. **Despliegue en Producción**: Los cambios se aplican automáticamente en el entorno de producción alojado en un VPS.

---

## 📝 Configuración Requerida

Para desplegar este proyecto, asegúrate de contar con los siguientes requisitos:

- **K3s** instalado en ambos entornos (local y VPS).
- **Jenkins** desplegado y configurado para ejecutar pipelines en el entorno de desarrollo.
- **Buildah** instalado en el entorno local y en el contenedor de Jenkins para la creación de imágenes de contenedores.
- Certificados SSL y configuración DNS para los dominios personalizados.

---

## 🔄 Sincronización de la Base de Datos

El pipeline de Jenkins incluye un paso que permite sincronizar la base de datos entre los entornos de desarrollo y producción. Esta operación garantiza que los cambios realizados localmente se reflejen en el entorno de producción sin pérdida de datos.

---

## 🤝 Contribuciones

Si deseas contribuir a este proyecto, eres bienvenido a realizar un **fork** del repositorio y enviar un **pull request** con tus sugerencias o mejoras.

---
