#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.
#
# If you have user-specific configurations you would like
# to apply, you may also create user-customizations.sh,
# which will be run after this script.


# If you're not quite ready for the latest Node.js version,
# uncomment these lines to roll back to a previous version

# Remove current Node.js version:
#sudo apt-get -y purge nodejs
#sudo rm -rf /usr/lib/node_modules/npm/lib
#sudo rm -rf //etc/apt/sources.list.d/nodesource.list

# Install Node.js Version desired (i.e. v13)
# More info: https://github.com/nodesource/distributions/blob/master/README.md#debinstall
#curl -sL https://deb.nodesource.com/setup_13.x | sudo -E bash -
#sudo apt-get install -y nodejs

wget https://get.symfony.com/cli/installer -O - | bash
export PATH="$HOME/.symfony/bin:$PATH"



# Install Keycloak and dependencies
sudo apt-get install -y openjdk-8-jre
if [ -d "keycloak-15.0.2" ] 
then
    echo "Delete existing keycloak installation"
    rm -R keycloak-15.0.2
fi

if [ ! -f "keycloak-15.0.2.zip" ] 
then
    echo "Download keycloak 15.0.2 archive"
    wget https://github.com/keycloak/keycloak/releases/download/15.0.2/keycloak-15.0.2.zip -O keycloak-15.0.2.zip
fi

echo "Extracting keycloak binaries..." 
unzip -q keycloak-15.0.2.zip
nohup ./keycloak-15.0.2/bin/standalone.sh -b 0.0.0.0 -Dkeycloak.migration.action=import -Dkeycloak.migration.provider=singleFile -Dkeycloak.migration.file="atypikhouse-api/data/keycloak-config.json" &>/dev/null &

# Create Database and schema
cd ~/atypikhouse-api
symfony console doctrine:database:drop --force
symfony console doctrine:database:create
symfony console doctrine:schema:create
php bin/console api:openapi:export --output=swagger_docs.json

# Wait for keycloak to start and import config
sleep 120
echo "Loading data fixtures"
symfony console doctrine:fixtures:load -n
