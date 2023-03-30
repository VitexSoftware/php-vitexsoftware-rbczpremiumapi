deffile=openapi-rbcz.yml

rm -rf lib docs test README.md

npx openapi-generator-cli generate -i ${deffile} -g php --git-user-id VitexSoftware --git-repo-id php-vitexsoftware-rbczpremiumapi -c .openapi-generator/config.yaml 



