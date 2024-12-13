pipeline {
    environment {
        IMAGE = "jairodh/wpimagen"
        REPO_URL = "https://github.com/JairoDH/Keptn-k3s.git"
        BUILD_DIR = "/home/jairo/Keptn-k3s"
        KUBE_CONFIG = "/etc/rancher/k3s/k3s.yaml"
        DOCKER_HUB = credentials('docker_hub')
        MYSQL_DB = 'wordpress'
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
  - name: kubectl
    image: lachlanevenson/k8s-kubectl:latest
    command:
    - cat
    tty: true
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
        stage('Check Event') {
            steps {
                script {
                    if (env.GITHUB_EVENT != 'published') {
                        error("Not a release event. Skipping build.")
                    }
                }
		echo "Release event detected. Proceeding with build."
            }
        }
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
                        // Actualizar repositorio
                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'cd ${BUILD_DIR} && git pull'"

                        // Cambiar permisos a la carpeta /Keptn-k3s/wordpress
                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'sudo chown -R www-data:www-data ${BUILD_DIR}/wordpress/*'"

                        // Comando para desplegar en el VPS
                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'kubectl --kubeconfig=${KUBE_CONFIG} apply -f ${BUILD_DIR}/k3s-dev/'"
                    }
                }
            }
        }
	stage('Migración de base de datos') {
	    steps {
               container('kubectl') {
                   script {
                       withCredentials([usernamePassword(credentialsId: 'MySQL', usernameVariable: 'MYSQL_USER', passwordVariable: 'MYSQL_PASSWORD')]) {
                         // Ejecutar mysqldump dentro del contenedor de MySQL en Kubernetes
                        sh """
                            kubectl exec -it \$(kubectl get pod -l app=mysql -o jsonpath='{.items[0].metadata.name}') -- \
                            /usr/bin/mysqldump -u\$MYSQL_USER -p\$MYSQL_PASSWORD ${MYSQL_DB} > /home/jairo/mysql_backup/backup.sql
                           """

                         // Copiar el archivo de respaldo al VPS
                        sh "scp /home/jairo/mysql_backup/backup.sql jairo@fekir.touristmap.es:/home/jairo/mysql_backup/backup.sql"

                         // Importar la base de datos en el VPS
                        sh "ssh jairo@fekir.touristmap.es 'kubectl exec -it \$(kubectl get pod -l app=mysql -o jsonpath='{.items[0].metadata.name}') -- \ 
			mysql -u\$MYSQL_USER -p\$MYSQL_PASSWORD ${MYSQL_DB} < /home/jairo/mysql_backup/backup.sql'"
                      }
                   }
               }
            }
        }
    }
}
