#export PHP_POST_PROCESS_FILE="phpcbf -q --standard=PSR12 --extensions=php --ignore=vendor/ lib/ examples/ test/"

deffile=01rbczpremiumapi.yaml

rm -rf lib docs test README.md

#First time installation: npm install @openapitools/openapi-generator-cli -g

npx openapi-generator-cli generate -i ${deffile} -g php --git-user-id VitexSoftware --git-repo-id php-vitexsoftware-rbczpremiumapi -c .openapi-generator/config.yaml #--enable-post-process-file

sed -i 's/$xIBMClientId,//' lib/PremiumAPI/*
sed -i '/@param  string $xIBMClientId/d' lib/PremiumAPI/*

sed -i 's/$pSUIPAddress = null,//' lib/PremiumAPI/*
sed -i 's/ $pSUIPAddress,//' lib/PremiumAPI/*

sed -i '/@param  string $pSUIPAddress IP address/d' lib/PremiumAPI/*


sed -i '/xIBMClientId_example/d' docs/Api/* README.md
sed -i '/pSUIPAddress_example/d' docs/Api/* README.md

sed -i 's/$xIBMClientId,//' docs/Api/* README.md
sed -i 's/$pSUIPAddress,//' docs/Api/* README.md

sed -i '/IBMClientId/d' docs/Api/*
sed -i '/SUIPAddress/d' docs/Api/*

make cs
