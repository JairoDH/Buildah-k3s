# Utilizar la imagen oficial de Jenkins como base
FROM jenkins/jenkins:lts

# Establecer el usuario root para realizar instalaciones
USER root

# Actualizar apt y añadir dependencias para Buildah
RUN apt-get update && apt-get install -y \
    software-properties-common \
    ca-certificates \
    curl \
    gnupg \
    lsb-release \
    fuse-overlayfs \
    && add-apt-repository -y ppa:projectatomic/ppa \
    && apt-get update \
    && apt-get install -y buildah \
    && apt-get install -y mysql-client \
    && apt-get install -y kubectl \
    && apt-get install -y sudo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Variables de entorno
ENV LANG=C.UTF-8
ENV JENKINS_HOME=/var/jenkins_home
ENV JENKINS_SLAVE_AGENT_PORT=50000
ENV REF=/usr/share/jenkins/ref
ENV JENKINS_UC=https://updates.jenkins.io
ENV JENKINS_UC_EXPERIMENTAL=https://updates.jenkins.io/experimental
ENV JENKINS_INCREMENTALS_REPO_MIRROR=https://repo.jenkins-ci.org/incrementals
ENV COPY_REFERENCE_FILE_LOG=/var/jenkins_home/copy_reference_file.log
ENV JAVA_HOME=/opt/java/openjdk
ENV PATH=/opt/java/openjdk/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
ENV KUBECONFIG=/home/jenkins/kubeconfig.yaml

EXPOSE 8080 50000

# Copiar archivos necesarios
COPY /javaruntime /opt/java/openjdk
COPY jenkins-support /usr/local/bin/jenkins-support
COPY jenkins.sh /usr/local/bin/jenkins.sh
COPY jenkins-plugin-cli.sh /bin/jenkins-plugin-cli
COPY /etc/rancher/k3s/k3s.yaml /home/jenkins/kubeconfig.yaml

# Establecer el directorio de trabajo y el usuario Jenkins
USER jenkins

# Volumen para persistir datos
VOLUME ["/var/jenkins_home"]

# Configuración de la entrada del contenedor
ENTRYPOINT ["/usr/bin/tini", "--", "/usr/local/bin/jenkins.sh"]

# Etiquetas para la imagen
LABEL org.opencontainers.image.vendor="Jenkins project" \
      org.opencontainers.image.title="Official Jenkins"

# Finalizar con el usuario root para permitir ciertas configuraciones finales
USER root

# Finalización de la instalación y configuraciones
RUN apt-get update && apt-get install -y \
    # Agregar aquí cualquier otra dependencia que necesites
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Regresar al usuario Jenkins para que el contenedor corra bajo este usuario
USER jenkins
