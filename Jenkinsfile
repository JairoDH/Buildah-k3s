pipeline {
    environment {
        IMAGE = "jairodh/wpimagen"
        REPO_URL = "https://github.com/JairoDH/Keptn-k3s.git"
        BUILD_DIR = "/home/jairo/Keptn-k3s"
        KUBE_CONFIG = "/etc/rancher/k3s/k3s.yaml"
        MYSQL_DB = "wordpress"
    }
    agent {
        kubernetes {
            yaml '''
apiVersion: v1
kind: Pod
metadata:
  name: buildah-pod
spec:
  containers:
  - name: buildah
    image: docker.io/jairodh/buildah:v2
    command:
    - cat
    tty: true
    securityContext:
      privileged: true
    volumeMounts:
      - name: varlibcontainers
        mountPath: /var/lib/containers
  volumes:
    - name: varlibcontainers
      emptyDir: {}
'''
        }
    }
    options {
        buildDiscarder(logRotator(numToKeepStr: '10'))
        durabilityHint('PERFORMANCE_OPTIMIZED')
        disableConcurrentBuilds()
    }
    stages {
        stage('Clonar repositorio') {
            steps {
                git branch: 'main', url: "${REPO_URL}"
            }
        }
        stage('Crear y subir imagen') {
            steps {
                container('buildah') {
                    script {
                        // Construcción de la imagen
                        sh "buildah build -t ${IMAGE}:${BUILD_NUMBER} ."

                        // Login en DockerHub utilizando las credenciales de Jenkins
                        withCredentials([usernamePassword(credentialsId: 'docker_hub', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                            // Realizar login en DockerHub
                            sh "echo ${DOCKER_PASS} | buildah login -u ${DOCKER_USER} --password-stdin docker.io"
                        }

                        // Push de la imagen
                        sh "buildah push ${IMAGE}:${BUILD_NUMBER} docker://docker.io/${IMAGE}:${BUILD_NUMBER}"
                    }
                }
            }
        }
        stage('Deployment') {
            agent any
            steps {
                script {
                    sshagent(credentials: ['VPS_SSH']) {
                        // Actualizar repositorio en el VPS
                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'cd ${BUILD_DIR} && git pull'"

                        // Cambiar permisos a la carpeta /Keptn-k3s/wordpress en el VPS
                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'sudo chown -R www-data:www-data ${BUILD_DIR}/wordpress/*'"

                        // Desplegar en el VPS con kubectl
                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'kubectl --kubeconfig=${KUBE_CONFIG} apply -f ${BUILD_DIR}/k3s-dev/'"
                    }
                }
            }
        }
        stage('Migración de base de datos') {
            agent any
            steps {
                script {
                    withCredentials([usernamePassword(credentialsId: 'MySQL', usernameVariable: 'MYSQL_USER', passwordVariable: 'MYSQL_PASSWORD')]) {
                        // Realizar el volcado de la base de datos en el clúster de Kubernetes
                        sh """
                            POD_NAME=\$(kubectl get pod -l app=mysql -o jsonpath='{.items[0].metadata.name}')
                            kubectl exec -it \${POD_NAME} -- /usr/bin/mysqldump -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DB} > /tmp/backup.sql
                        """
                        
                        // Copiar el archivo de respaldo al VPS
                        sh "scp /tmp/backup.sql jairo@fekir.touristmap.es:/tmp/backup.sql"

                        // Importar la base de datos en el VPS
                        sh "ssh jairo@fekir.touristmap.es 'mysql -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DB} < /tmp/backup.sql'"
                    }
                }
            }
        }
    }
}
