pipeline {
    environment {
        IMAGE = "jairodh/wpimagen"
        REPO_URL = "https://github.com/JairoDH/Keptn-k3s.git"
        BUILD_DIR = "/home/jairo/Keptn-k3s"
        KUBE_CONFIG = "/etc/rancher/k3s/k3s.yaml"
        DOCKER_HUB = credentials('docker_hub')
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
        stage('Clonar repositorio') {
            steps {
                git branch: "${env.BRANCH_NAME}",
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

        stage('Deployment') {
            steps {
                script {
                    if (env.BRANCH_NAME == "prod") {
                        sshagent(credentials: ['VPS_SSH']) {
                            // Actualizar repositorio y permisos
                            sh """
                                ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'cd ${BUILD_DIR} && git pull'
                                ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'sudo chown -R www-data:www-data ${BUILD_DIR}/wordpress/*'
                                ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'kubectl --kubeconfig=${KUBE_CONFIG} apply -f ${BUILD_DIR}/k3s/'
                            """
                        }
                    } else if (env.BRANCH_NAME == "main") {
                        // Despliegue local
                        sh """
                            cd ${BUILD_DIR} && git pull
                            kubectl --kubeconfig=${KUBE_CONFIG} apply -f ${BUILD_DIR}/k3s/
                        """
                    }
                }
            }
        }
    }
}

