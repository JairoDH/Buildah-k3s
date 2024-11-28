pipeline {
    environment {
        IMAGE = "jairodh/wpimagen"
        LOGIN = credentials("DOCKER_HUB")
        REPO_URL = "https://github.com/JairoDH/Keptn-k3s.git"
        BUILD_DIR = "Keptn-k3s/k3s"
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
        stage('Clone') {
            steps {
                git branch: 'main', url: "${REPO_URL}"
            }
        }
        stage('Build and Push Image') {
            steps {
                container('buildah') {
                    script {
                        // Construcción de la imagen
                        sh "buildah build -t ${IMAGE}:${BUILD_NUMBER} ."

                        // Login en Docker Hub
                        docker.withRegistry('', LOGIN) 

                        // Push de la imagen
                        sh "buildah push ${IMAGE}:${BUILD_NUMBER} docker://docker.io/${IMAGE}:${BUILD_NUMBER}"
                    }
                }
            }
        }
        stage('Deploy to Development') {
            steps {
                script {
                    withKubeConfig([credentialsId: 'kubeconfig-credentials-id', serverUrl: 'https://kubernetes-server-url']) {
                        sh """
                            kubectl apply -f ${BUILD_DIR}/mysql-deployment.yaml
                            kubectl apply -f ${BUILD_DIR}/wordPress-deployment.yaml
                            kubectl apply -f ${BUILD_DIR}/ingress.yaml
                        """
                    }
                }
            }
        }
        stage('Integration Tests') {
            steps {
                sh "curl -I http://www.veinttidos.org | grep '200 OK'"
            }
        }
    }
}
