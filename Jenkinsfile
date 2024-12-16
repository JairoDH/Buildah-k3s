pipeline {
    environment {
        IMAGE = "jairodh/wpimagen"
        REPO_URL = "https://github.com/JairoDH/Keptn-k3s.git"
        BUILD_DIR = "/home/jairo/Keptn-k3s"
        KUBE_CONFIG = "/etc/rancher/k3s/k3s.yaml"
        DOCKER_HUB = credentials('docker_hub')
        GIT_BRANCH = "${git_branch}"
    }

    agent any
    
    options {
        buildDiscarder(logRotator(numToKeepStr: '10'))
        durabilityHint('PERFORMANCE_OPTIMIZED')
        disableConcurrentBuilds()
    }

    stages {
        stage('Verificar rama') {
            steps {
                script {
                    if (!env.GIT_BRANCH.contains("main")) {
                        currentBuild.result = 'ABORTED'
                        error("Este pipeline solo debe ejecutarse en la rama 'main'")
                    }
                }
            }
        }

        stage('Clonar repositorio') {
            steps {
                git branch: 'main',
                    url: "${REPO_URL}"
            }
        }

        stage('Crear y subir imagen') {
            steps {
                container('buildah') {
                    script {
                        // Construcción de la imagen
                        sh "buildah build -t ${IMAGE}:${BUILD_NUMBER} ."
                        
                        // Login en Docker Hub utilizando las credenciales de Jenkins
                        withCredentials([
                            usernamePassword(
                                credentialsId: 'docker_hub',
                                usernameVariable: 'DOCKER_USER',
                                passwordVariable: 'DOCKER_PASS'
                            )
                        ]) {
                            // Realizar login en Docker Hub
                            sh "echo ${DOCKER_PASS} | buildah login -u ${DOCKER_USER} --password-stdin docker.io"
                            // Push de la imagen
                            sh "buildah push ${IMAGE}:${BUILD_NUMBER} docker://docker.io/${IMAGE}:${BUILD_NUMBER}"
                        }
                    }
                }
            }
        }

        stage('Migración de la base de datos') {
            steps {
                script {
                    // Ejecutar el script en la máquina local
                    sh "sh /home/jairo/Keptn-k3s/scriptbackup.sh"
                    
                    // Usar SCP para transferir el archivo .sql a la VPS
                    sh "scp /home/jairo/databd.sql jairo@touristmap.es:/home/jairo/"
                }
            }
        }

        stage('Deployment') {
            steps {
                script {
                    sshagent(credentials: ['VPS_SSH']) {
                        // Actualizar repositorio
                        sh "ssh -o StrictHostKeyChecking=no jairo@touristmap.es 'cd ${BUILD_DIR} && git pull'"
                        // Cambiar permisos a la carpeta /Keptn-k3s/wordpress
                        sh "ssh -o StrictHostKeyChecking=no jairo@touristmap.es 'sudo chown -R jairo:www-data ${BUILD_DIR}/wordpress/*'"
                        // Comando para desplegar en el VPS
                        sh "ssh -o StrictHostKeyChecking=no jairo@touristmap.es 'kubectl --kubeconfig=${KUBE_CONFIG} apply -f ${BUILD_DIR}/k3s-dev/'"
                        sh "ssh -o StrictHostKeyChecking=no jairo@touristmap.es 'kubectl --kubeconfig=${KUBE_CONFIG} apply -f ${BUILD_DIR}/ingressprod.yaml'"
                    }
                }
            }
        }
    }        
}
