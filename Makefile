deffile = openapi-rbcz.yml

generate:
	npx openapi-generator-cli generate -i ${deffile} -g php --git-user-id VitexSoftware --git-repo-id php-vitexsoftware-raiffeisenbank -c .openapi-generator/config.yaml 

empty:
	rm -rf lib docs test

