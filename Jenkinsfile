kpipeline {
    environment {
        IMAGE = "jairodh/wpimagen"
        REPO_URL = "https://github.com/JairoDH/Keptn-k3s.git"
        BUILD_DIR = "/home/jairo/Keptn-k3s"
        KUBE_CONFIG = "/etc/rancher/k3s/k3s.yaml"
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
                      tty: true
                      securityContext:
                        privileged: true
                      volumeMounts:
                      - name: varlibcontainers
                        mountPath: /var/lib/containers
                    - name: kubectl
                      image: lachlanevenson/k8s-kubectl:latest
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
        stage('Verificar rama') {
            steps {
                script {
                    if (env.BRANCH_NAME != 'prod') {
                        currentBuild.result = 'ABORTED'
                        error("Este pipeline solo debe ejecutarse en la rama 'prod'")
                    }
                }
            }
        }

        stage('Clonar repositorio') {
            steps {
                git branch: 'prod', url: "${REPO_URL}"
            }
        }

        stage('Crear y subir imagen') {
            steps {
                container('buildah') {
                    script {
                            sh "buildah build -t ${IMAGE}:${BUILD_NUMBER} ."
                            withCredentials([usernamePassword(credentialsId: 'docker_hub', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                            sh "echo ${DOCKER_PASS} | buildah login -u ${DOCKER_USER} --password-stdin docker.io"
                            sh "buildah push ${IMAGE}:${BUILD_NUMBER} docker://docker.io/${IMAGE}:${BUILD_NUMBER}"
                        }
                    }
                }
            }
        }

        stage('Deployment') {
            steps {
                script {
                    sshagent(credentials: ['VPS_SSH']) {
                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'cd ${BUILD_DIR} && git pull'"
                        sh "ssh -o StrictHostKeyChecking=no jairo@fekir.touristmap.es 'sudo chown -R www-data:www-data ${BUILD_DIR}/wordpress/*'"
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
                            sh "mkdir -p /home/jairo/mysql_backup"
                            sh """
                                kubectl exec -it $(kubectl get pod -l app=mysql -o jsonpath='{.items[0].metadata.name}') -- \
                                /usr/bin/mysqldump -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DB} > /home/jairo/mysql_backup/backup.sql
                            """
                            sh "scp /home/jairo/mysql_backup/backup.sql jairo@fekir.touristmap.es:/home/jairo/mysql_backup/backup.sql"
                            sh """
                                ssh jairo@fekir.touristmap.es 'kubectl exec -it $(kubectl get pod -l app=mysql -o jsonpath="{.items[0].metadata.name}") -- \
                                mysql -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DB} < /home/jairo/mysql_backup/backup.sql'
                            """
                        }
                    }
                }
            }
        }
    }
}

