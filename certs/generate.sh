# This script generate an SSL cert files,
# and should be used in manual mode or by CI/CD

CN=$1 # Country Name (2 letter code)
ST=$2 # State or Province Name (full name)
LN=$3 # Locality Name (eg, city)
ON=$4 # Organization Name (eg, company)
OU=$5 # Organizational Unit Name (eg, section)
CO=$6 # Common Name (e.g. server FQDN or YOUR name)
EA=$7 # Email Address

openssl genrsa 2048 > secret.key
chmod 400 secret.key
openssl req -new -x509 -nodes -sha256 -days 365 -key secret.key -out public.crt <<< $CN$'\n'$ST$'\n'$LN$'\n'$ON$'\n'$OU$'\n'$CO$'\n'$EA
