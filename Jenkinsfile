pipeline {
    environment {
        IMAGE = "jairodh/wpimagen"
        LOGIN = "DOCKER_HUB"
        REPO_URL = "https://github.com/JairoDH/Keptn-k3s.git"
        BUILD_DIR = "Keptn-k3s"
        KUBE_CONFIG = "/etc/rancher/k3s/k3s.yaml"
    }
    agent none
    stages {
        stage('Clone') {
            agent any
            steps {
                git branch: 'main', url: "${REPO_URL}"
            }
        }
        stage('Build-Image') {
            agent any
            stages {
                stage('Build Image with Buildah') {
                    steps {
                        script {
                            sh "buildah bud --tag ${IMAGE}:${BUILD_NUMBER} ."
                        }
                    }
                }
                stage('Push Image') {
                    steps {
                        script {
                            sh "buildah push ${IMAGE}:${BUILD_NUMBER} docker://docker.io/jairodh/${IMAGE:${BUILD_NUMBER}"
                        }
                    }
                }
                stage('Remove Image') {
                    steps {
                        script {
                            // Limpiar las imágenes locales
                            sh "buildah rmi ${IMAGE}:${BUILD_NUMBER}"
                        }
                    }
                }
            }
        }
        stage('Deploy to Development') {
            steps {
                sh """
                    kubectl apply -f ${BUILD_DIR}/k3s/mysql-deployment.yaml
                    kubectl apply -f ${BUILD_DIR}/k3s/wordPress-deployment.yaml
                    kubectl apply -f ${BUILD_DIR}/k3s/ingress.yaml
                """
            }
        }
        stage('Integration Tests') {
            steps {
                sh "curl -I http://www.veinttidos.org" | grep '200 OK'"
            }
        }
#        stage('Deployment') {
#            agent any
#            steps {
#                script {
#                    sshagent(credentials: ['VPS_SSH']) {
#                        // Comando para desplegar en el VPS
#                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'kubectl --kubeconfig=${KUBE_CONFIG} apply -f /home/jairo/Keptn-k3s/k3s/wordPress-deployment.yaml'"
#                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'kubectl --kubeconfig=${KUBE_CONFIG} apply -f /home/jairo/Keptn-k3s/k3s/wordPress-srv.yaml'"
#                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'kubectl --kubeconfig=${KUBE_CONFIG} apply -f /home/jairo/Keptn-k3s/k3s/ingress.yaml'"                    }
#                }
#            }
#        } 
#    }
    post {
        always {
            mail to: 'jairo.snort35@gmail.com',
            subject: "Status of pipeline: ${currentBuild.fullDisplayName}",
            body: "${env.BUILD_URL} has result ${currentBuild.result}"
        }
    }
}
