deffile=openapi-rbcz.yml

rm -rf lib docs test README.md

npx openapi-generator-cli generate -i ${deffile} -g php --git-user-id VitexSoftware --git-repo-id php-vitexsoftware-rbczpremiumapi -c .openapi-generator/config.yaml 
sed -i 's/$xIBMClientId,//' lib/PremiumAPI/*
sed -i '/@param  string $xIBMClientId/d' lib/PremiumAPI/*

sed -i 's/$pSUIPAddress = null,//' lib/PremiumAPI/*
sed -i 's/ $pSUIPAddress,//' lib/PremiumAPI/*

sed -i '/@param  string $pSUIPAddress IP address/d' lib/PremiumAPI/*


sed -i '/xIBMClientId_example/d' docs/Api/*
sed -i '/pSUIPAddress_example/d' docs/Api/*

sed -i 's/$xIBMClientId,//' docs/Api/*
sed -i 's/$pSUIPAddress,//' docs/Api/*

sed -i '/IBMClientId/d' docs/Api/*
sed -i '/SUIPAddress/d' docs/Api/*
