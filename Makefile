deffile = openapi-rbcz.yml

generate:
	npx openapi-generator-cli generate -i ${deffile} -g php --git-user-id VitexSoftware --git-repo-id libpython-semaphore-client -c .openapi-generator/config.yaml 

